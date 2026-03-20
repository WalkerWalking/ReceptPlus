import { computed, Injectable, Signal, signal, inject } from '@angular/core';
import { Recipe } from './models/recipe.model';
import { map, Observable, tap, catchError, throwError } from 'rxjs';
import { HttpClient } from '@angular/common/http';
import { AuthService } from './auth-service';
import { UserIngredient } from './models/userIngredient.model';
import { UserStorageService } from './user-storage-service';
import { Ingredient } from './models/ingredient.model';
import { ToastService } from './toastwindowservice';

@Injectable({
  providedIn: 'root'
})
export class RecipeService {
  private http = inject(HttpClient);
  private auth = inject(AuthService);
  private storage = inject(UserStorageService);
  private toast = inject(ToastService);

  constructor() {
    this.getSelectedRecipe();
  }

  searchTerm = signal<string>('');

  setSearchTerm(term: string) {
    this.searchTerm.set(term);
  }

  private _recipes = signal<Recipe[]>([]);
  recipes = this._recipes.asReadonly();

  selectedRecipe = signal<Recipe>(this.recipes()[0]);

  setSelectedRecipe(recipe: Recipe) {
    this.selectedRecipe.set(recipe);
    localStorage.setItem('selectedRecipe', JSON.stringify(recipe));
  }

  getSelectedRecipe() {
    const savedRecipe = localStorage.getItem('selectedRecipe');
    if (savedRecipe) {
      const recipe: Recipe = JSON.parse(savedRecipe);
      this.selectedRecipe.set(recipe);
    }
  }

  filteredRecipes = computed(() => {
    const all = this.recipes();
    const term = this.searchTerm().toLowerCase().trim();
    if (term.length < 3) return all;
    return all.filter(r =>
      r.name.toLowerCase().includes(term) ||
      r.ingredients.some(ing => ing.name.toLowerCase().includes(term))
    );
  });

  makeableRecipes = computed(() => {
    const recipes = this.recipes();
    const userIngredients = this.storage.userIngredients();
    const term = this.searchTerm().toLowerCase().trim();

    if (!recipes.length || !userIngredients.length) return [];
    const canMake = recipes.filter(recipe => this.isMakeable(recipe, userIngredients));

    if (term.length < 3) return canMake;
    return canMake.filter(r =>
      r.name.toLowerCase().includes(term) ||
      r.ingredients.some(ing => ing.name.toLowerCase().includes(term))
    );
  });

  isMakeable(recipe: Recipe, userIngredients: UserIngredient[]): boolean {
    for (const ingredient of recipe.ingredients) {
      const userIngredient = userIngredients.find(ui => ui.name === ingredient.name);
      if (!userIngredient || userIngredient.amount < ingredient.amount) return false;
    }
    return true;
  }

  getRecipes() {
    this.http.get<any[]>("http://127.0.0.1:8000/api/recipes/getAllRecipesWithIngredients")
      .pipe(
        map(response => response.map(recipe => this.mapRecipe(recipe))),
        catchError(err => {
          this.toast.show('Nem sikerült betölteni a recepteket.', 'error');
          return throwError(() => err);
        })
      ).subscribe(data => this._recipes.set(data));
  }

  makeRecipe(recipeId: number) {
    return this.http.post<any>(
      `http://127.0.0.1:8000/api/recipes/make/${this.auth.loggedInUser()?.id}/${recipeId}`, {}
    ).pipe(
      tap(() => this.toast.show('Jó étvágyat! Az alapanyagokat levontuk a raktáradból.', 'success')),
      catchError(err => {
        this.toast.show('Hiba történt a főzés során.', 'error');
        return throwError(() => err);
      })
    );
  }

  createRecipe(formData: FormData) {
    return this.http.post<any>('http://127.0.0.1:8000/api/recipes', formData).pipe(
      tap(() => this.toast.show('Recept sikeresen beküldve!', 'success')),
      catchError(err => {
        this.toast.show('Nem sikerült menteni a receptet. Ellenőrizd a mezőket!', 'error');
        return throwError(() => err);
      })
    );
  }

  deleteRecipe(recipeId: number) {
    return this.http.delete<any>(`http://127.0.0.1:8000/api/recipes/delete/${recipeId}`).pipe(
      tap(() => this.toast.show('Recept törölve.', 'info')),
      catchError(err => {
        this.toast.show('Hiba a törlés közben.', 'error');
        return throwError(() => err);
      })
    );
  }

  getUserRecipes(): Observable<Recipe[]> {
    return this.http.get<any[]>(`http://127.0.0.1:8000/api/users/recipes/${this.auth.loggedInUser()?.id}`)
      .pipe(
        map(response => response.map(recipe => this.mapRecipe(recipe))),
        catchError(err => {
          this.toast.show('Hiba a saját receptek betöltésekor.', 'error');
          return throwError(() => err);
        })
      );
  }

  getIngredients() {
    return this.http.get<Ingredient[]>('http://127.0.0.1:8000/api/ingredients');
  }

  private mapRecipe(recipe: any): Recipe {
    return {
      id: recipe.id,
      name: recipe.name,
      userId: recipe.userId,
      imageUrl: recipe.imageUrl,
      isMakeable: recipe.isMakeable,
      description: recipe.description,
      calories: recipe.calories,
      ingredients: recipe.ingredients.map((ingredient: any) => ({
        id: ingredient.id,
        name: ingredient.name,
        amount: ingredient.pivot.amount,
        unit: ingredient.unit
      }))
    };
  }
}