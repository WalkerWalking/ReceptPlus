import { Component, Signal } from '@angular/core';
import { RecipeService } from '../recipe.service';
import { Recipe } from '../models/recipe.model';
import { Router } from "@angular/router";

@Component({
  selector: 'app-all-recipes',
  imports: [],
  templateUrl: './all-recipes.html',
  styleUrl: './all-recipes.scss',
})
export class AllRecipes {
  recipes!:Signal<Recipe[]>;
  darabosHozzavalok!:Signal<string[]>;

  constructor(private recipeService: RecipeService, private router: Router) { }

  ngOnInit(): void {
    this.recipeService.getRecipes();
    this.recipes = this.recipeService.recipes; 
  }

  goToRecipe(recipe: Recipe){
    this.router.navigate(['/recipe-full']);
    this.recipeService.setSelectedRecipe(recipe);
  }
}
