import { Component, Signal } from '@angular/core';
import { Recipe } from '../models/recipe.model';
import { RecipeService } from '../recipe.service';
import { Userrecepies } from "../userrecepies/userrecepies";
import { UserStorageService } from '../user-storage-service';
import { Router } from '@angular/router';
@Component({
  selector: 'app-recepiesfrominventory',
  imports: [],
  templateUrl: './recepiesfrominventory.html',
  styleUrl: './recepiesfrominventory.scss',
})
export class Recepiesfrominventory {
  
  makeableRecipes!:Signal<Recipe[]>;

  constructor(private recipeService: RecipeService, private storage: UserStorageService, private router: Router) { }

  ngOnInit(): void {
    this.recipeService.getRecipes();    
    this.storage.getUserIngredients();
    this.makeableRecipes = this.recipeService.makeableRecipes;
  }

  goToRecipe(recipe: Recipe){
    this.router.navigate(['/recipe-full']);
    this.recipeService.setSelectedRecipe(recipe);
  }

}
