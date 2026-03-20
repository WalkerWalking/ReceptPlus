import { Component, signal, OnInit, inject, computed } from '@angular/core';
import { Recipe } from '../models/recipe.model';
import { RecipeService } from '../recipe.service';
import { Router, RouterLink } from '@angular/router';
import { ToastService } from '../toastwindowservice';

@Component({
  selector: 'app-userrecepies',
  standalone: true,
  imports: [RouterLink],
  templateUrl: './userrecepies.html',
  styleUrl: './userrecepies.scss',
})
export class Userrecepies implements OnInit {
  public recipeService = inject(RecipeService);
  private router = inject(Router);
  private toastService = inject(ToastService);

  private _allMyRecipes = signal<Recipe[]>([]);

  userRecipes = computed(() => {
    const recipes = this._allMyRecipes();
    const term = this.recipeService.searchTerm().toLowerCase().trim();

    if (term.length < 3) return recipes;

    return recipes.filter(r => 
      r.name.toLowerCase().includes(term) || 
      r.ingredients.some(i => i.name.toLowerCase().includes(term))
    );
  });

  ngOnInit() {
    this.loadUserRecipes();
  }

  loadUserRecipes() {
    this.recipeService.getUserRecipes().subscribe({
      next: (data) => {
        this._allMyRecipes.set(data);
      },
      error: (err) => {
        console.error('Hiba a saját receptek betöltésekor:', err);
        this.toastService.show('Nem sikerült betölteni a receptjeidet.', 'error');
      }
    });
  }

  goToRecipe(recipe: Recipe) {
    this.recipeService.setSelectedRecipe(recipe);
    this.router.navigate(['/recipe-full']);
  }

  async deleteRecipe(recipe: Recipe) {
    const confirmed = await this.toastService.askConfirmation(
      'Recept törlése',
      `Biztosan véglegesen törölni szeretnéd a(z) "${recipe.name}" receptet?`
    );

    if (!confirmed) return;

    this.recipeService.deleteRecipe(recipe.id).subscribe({
      next: (res) => {
        this.toastService.show(res['Siker!'] || `"${recipe.name}" törölve.`, 'success');
        this.loadUserRecipes(); 
      },
      error: (err) => {
        console.error('Törlési hiba:', err);
        this.toastService.show('Hiba történt a törlés során. Próbáld újra később.', 'error');
      }
    });
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