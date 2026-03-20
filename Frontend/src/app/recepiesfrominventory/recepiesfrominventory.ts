import { Component, Signal } from '@angular/core';
import { Recipe } from '../models/recipe.model';
import { RecipeService } from '../recipe.service';
import { Userrecepies } from "../userrecepies/userrecepies";
import { UserStorageService } from '../user-storage-service';
import { Router, RouterLink } from '@angular/router';
@Component({
  selector: 'app-recepiesfrominventory',
  imports: [RouterLink],
  templateUrl: './recepiesfrominventory.html',
  styleUrl: './recepiesfrominventory.scss',
})
export class Recepiesfrominventory {

  makeableRecipes!: Signal<Recipe[]>;

  constructor(private recipeService: RecipeService, private storage: UserStorageService, private router: Router) { }

  ngOnInit(): void {
    this.recipeService.getRecipes();
    this.storage.getUserIngredients();
    this.makeableRecipes = this.recipeService.makeableRecipes;
  }

  goToRecipe(recipe: Recipe) {
    this.router.navigate(['/recipe-full']);
    this.recipeService.setSelectedRecipe(recipe);
  }


  calculateSmartTime(recipe: Recipe): number {
    let score = 15;

    const ingredientCount = recipe.ingredients?.length || 0;
    score += ingredientCount * 4;

    const descriptionLength = recipe.description?.length || 0;
    score += Math.floor(descriptionLength / 100) * 5;

    const fullText = (recipe.name + ' ' + (recipe.description || '')).toLowerCase();

    const logicGroups = [
      {
        tags: ['lassú', 'pörkölt', 'ragu', 'párol', 'dinsztel', 'konfit', 'abál', 'gőzöl', 'pörköl', 'érlel'],
        value: 40
      },
      {
        tags: ['sütő', 'tepsi', 'süss', 'gratin', 'rakott', 'csőben', 'pirít', 'pörzsöl', 'kérgez'],
        value: 30
      },
      {
        tags: ['keleszt', 'pihentet', 'dagaszt', 'kovász', 'tészta', 'gyúr', 'nyújt', 'hajtogat'],
        value: 50
      },
      {
        tags: ['panír', 'rántott', 'bundáz', 'töltött', 'göngyölt', 'formáz', 'szaggat', 'derelye', 'gombóc'],
        value: 25
      },
      {
        tags: ['pácol', 'éjszaka', 'másnap', 'hűtő', 'fagyaszt', 'dermed', 'kocsonya'],
        value: 80
      },
      {
        tags: ['tisztít', 'pucol', 'filéz', 'csontoz', 'darál', 'reszel'],
        value: 15
      }
    ];

    const ingredientSpecifics = [
      { tags: ['marha', 'vad', 'szarvas', 'őz', 'nyúl', 'bab', 'lencse', 'csülök'], value: 45 },
      { tags: ['egész csirke', 'pulyka', 'kacsa', 'liba'], value: 30 },
      { tags: ['krumpli', 'burgonya', 'répa', 'zeller'], value: 10 }
    ];

    const speedTags = [
      { tags: ['gyors', 'expressz', '5 perc', '10 perc', 'azonnal', 'nyers', 'saláta', 'turmix', 'smoothie'], value: -25 },
      { tags: ['konzerv', 'fagyasztott', 'konyhakész'], value: -10 }
    ];

    logicGroups.forEach(group => {
      if (group.tags.some(t => fullText.includes(t))) score += group.value;
    });

    ingredientSpecifics.forEach(group => {
      if (group.tags.some(t => fullText.includes(t))) score += group.value;
    });

    speedTags.forEach(group => {
      if (group.tags.some(t => fullText.includes(t))) score += group.value;
    });

    let finalTime = Math.ceil(score / 5) * 5;

    return Math.min(Math.max(finalTime, 10), 300);
  }

}
