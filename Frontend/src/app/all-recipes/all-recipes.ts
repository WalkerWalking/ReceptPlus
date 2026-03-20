import { Component, Signal, computed, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Recipe } from '../models/recipe.model';
import { RecipeService } from '../recipe.service';
import { Router } from '@angular/router';
import { AuthService } from '../auth-service';

@Component({
  selector: 'app-all-recipes',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './all-recipes.html',
  styleUrl: './all-recipes.scss',
})
export class AllRecipes implements OnInit {
  public recipeService = inject(RecipeService);
  public auth = inject(AuthService);
  private router = inject(Router);

  recipes: Signal<Recipe[]> = this.recipeService.recipes;

  filteredRecipes = computed(() => {
    const all = this.recipes();
    const term = this.recipeService.searchTerm().toLowerCase().trim();

    if (term.length < 3) return all;

    return all.filter(recipe =>
      recipe.name.toLowerCase().includes(term) ||
      recipe.ingredients.some(ing => ing.name.toLowerCase().includes(term))
    );
  });

  ngOnInit(): void {
    this.recipeService.getRecipes();
  }

  goToRecipe(recipe: Recipe) {
    this.recipeService.setSelectedRecipe(recipe);
    this.router.navigate(['/recipe-full']);
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