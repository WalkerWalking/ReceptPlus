import { Component, signal } from '@angular/core';
import { Recipe } from '../models/recipe.model';
import { RecipeService } from '../recipe.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-userrecepies',
  imports: [],
  templateUrl: './userrecepies.html',
  styleUrl: './userrecepies.scss',
})
export class Userrecepies {

  constructor(private recipeService: RecipeService, private router: Router){}

  private _userRecipes = signal<Recipe[]>([]);
  userRecipes = this._userRecipes.asReadonly();

  ngOnInit(){
    this.recipeService.getUserRecipes().subscribe(data=>{
      this._userRecipes.set(data);
    })    
  }

  goToRecipe(recipe: Recipe){
    this.router.navigate(['/recipe-full']);
    this.recipeService.setSelectedRecipe(recipe);
  }

}
