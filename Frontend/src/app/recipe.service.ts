import { computed, Injectable, Signal, signal } from '@angular/core';
import { Recipe } from './models/recipe.model';
import { map, Observable, of } from 'rxjs';
import { HttpClient } from '@angular/common/http';
import { AuthService } from './auth-service';
import { UserIngredient } from './models/userIngredient.model';
import { UserStorageService } from './user-storage-service';
import { SignalNode } from '@angular/core/primitives/signals';

@Injectable({
  providedIn: 'root'
})
export class RecipeService {

  constructor(private http: HttpClient, private auth: AuthService, private storage: UserStorageService) {
    this.getSelectedRecipe();
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

  makeableRecipes = computed(() => {
    const recipes = this.recipes();
    const userIngredients = this.storage.userIngredients();

    if (!recipes.length || !userIngredients.length) {
      return [];
    }

    return recipes.filter(recipe => this.isMakeable(recipe, userIngredients));
  });

  isMakeable(recipe: Recipe, userIngredients: UserIngredient[]): boolean {
    for (const ingredient of recipe.ingredients) {
      const userIngredient = userIngredients.find(
        ui => ui.name === ingredient.name
      );

      if (!userIngredient || userIngredient.amount < ingredient.amount) {
        return false;
      }
    }

    return true;
  }

  getRecipes() {
    this.http.get<any[]>("http://127.0.0.1:8000/api/recipes/getAllRecipesWithIngredients")
      .pipe(
        map(response =>
          response.map(recipe => ({
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
          }))
        )
      ).subscribe(data => {
        this._recipes.set(data);
      });
  }

  getUserRecipes(): Observable<Recipe[]> {
    return this.http.get<any[]>(`http://127.0.0.1:8000/api/users/recipes/${this.auth.loggedInUser()?.id}`)
      .pipe(
        map(response =>
          response.map(recipe => ({
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
          }))
        )
      )
  }

  updateCalorie(calorie: number) {
    this.http.put
  }

  makeRecipe(recipeId: number) {
    return this.http.post<any>(
      `http://127.0.0.1:8000/api/recipes/make/${this.auth.loggedInUser()?.id}/${recipeId}`,
      {}
    );
  }
  
}
