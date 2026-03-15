import { Component, inject, numberAttribute, Signal } from '@angular/core';
import { RecipeService } from '../recipe.service';
import { Recipe } from '../models/recipe.model';
import { Router } from '@angular/router';
import { AuthService } from '../auth-service';
import { count } from 'rxjs';
import { Userstorage } from '../userstorage/userstorage';
import { UserStorageService } from '../user-storage-service';

@Component({
  selector: 'app-recipe-full',
  imports: [],
  templateUrl: './recipe-full.html',
  styleUrl: './recipe-full.scss',
})
export class RecipeFull {

  private recipeService = inject(RecipeService);
  private userStorageService = inject(UserStorageService);
  private router = inject(Router);
  private auth = inject(AuthService);

  selectedRecipe!: Signal<Recipe>

  ngOnInit() {
    this.selectedRecipe = this.recipeService.selectedRecipe
  }

  backToHome() {
    this.router.navigate([''])
  }

  makeSelectedRecipe() {
    const recipe = this.selectedRecipe();
    if (!recipe) return;

    this.recipeService.makeRecipe(recipe.id).subscribe({
      next: (response) => {
        this.auth.loggedInUser.set(response.user);
        localStorage.setItem('loggedInUser', JSON.stringify(response.user));

        this.userStorageService.setUserIngredients(response.remainingIngredients);

        alert("Recept sikeresen elkészítve :3");
      },
      error: (err) => {
        console.error(err);
        alert(err.error?.message ?? 'Hiba történt');
      }
    });
  }

}
