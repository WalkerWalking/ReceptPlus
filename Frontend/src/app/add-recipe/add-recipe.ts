import { Component, OnInit, signal, inject, computed, HostListener } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { RecipeService } from '../recipe.service';
import { AuthService } from '../auth-service';
import { RecipeIngredient } from '../models/recipe.model';
import { Ingredient } from '../models/ingredient.model';
import { ToastService } from '../toastwindowservice';

@Component({
  selector: 'app-add-recipe',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './add-recipe.html',
  styleUrl: './add-recipe.scss',
})
export class AddRecipe implements OnInit {
  private recipeService = inject(RecipeService);
  private router = inject(Router);
  private toast = inject(ToastService);
  public auth = inject(AuthService);

  ingredients = signal<RecipeIngredient[]>([]);
  private _allAvailableIngredients = signal<Ingredient[]>([]);
  ingredientSearchTerm = signal('');
  isDropdownOpen = signal(false);

  recipeName = '';
  recipeDescription = '';
  selectedFile: File | null = null;
  imagePreview = signal<string | null>(null);

  filteredAvailableIngredients = computed(() => {
    const term = this.ingredientSearchTerm().toLowerCase().trim();
    if (!term) return this._allAvailableIngredients();
    return this._allAvailableIngredients().filter(ing => 
      ing.name.toLowerCase().includes(term)
    );
  });

  @HostListener('document:click', ['$event'])
  onClickOutside(event: Event) {
    const target = event.target as HTMLElement;
    if (!target.closest('.custom-dropdown-container')) {
      this.isDropdownOpen.set(false);
    }
  }

  ngOnInit() {
    this.recipeService.getIngredients().subscribe({
      next: (res) => this._allAvailableIngredients.set(res),
      error: () => this.toast.show('Nem sikerült betölteni az alapanyagokat.', 'error')
    });
  }

  calculateSmartTime(): number {
    let score = 15;
    const ingCount = this.ingredients().length;
    score += ingCount * 4;

    const fullText = (this.recipeName + ' ' + (this.recipeDescription || '')).toLowerCase();

    const logicGroups = [
      { tags: ['lassú', 'pörkölt', 'ragu', 'párol', 'dinsztel', 'konfit', 'abál'], value: 40 },
      { tags: ['sütő', 'tepsi', 'süss', 'gratin', 'rakott', 'csőben'], value: 30 },
      { tags: ['keleszt', 'pihentet', 'dagaszt', 'tészta', 'gyúr'], value: 50 },
      { tags: ['panír', 'rántott', 'bundáz', 'töltött', 'göngyölt'], value: 25 },
      { tags: ['pácol', 'éjszaka', 'hűtő', 'érlel'], value: 80 }
    ];

    logicGroups.forEach(group => {
      if (group.tags.some(t => fullText.includes(t))) score += group.value;
    });

    if (fullText.includes('gyors') || fullText.includes('expressz') || fullText.includes('saláta')) {
      score -= 20;
    }

    let finalTime = Math.ceil(score / 5) * 5;
    return Math.min(Math.max(finalTime, 10), 300);
  }

  onFileSelected(event: Event) {
    const input = event.target as HTMLInputElement;
    if (input.files?.[0]) {
      this.selectedFile = input.files[0];
      const reader = new FileReader();
      reader.onload = () => this.imagePreview.set(reader.result as string);
      reader.readAsDataURL(this.selectedFile);
    }
  }

  removeImage() {
    this.selectedFile = null;
    this.imagePreview.set(null);
  }

  selectIngredient(ing: Ingredient) {
    const exists = this.ingredients().some(i => i.id === ing.id);
    if (exists) {
      this.toast.show('Ez a hozzávaló már szerepel a listán!', 'info');
    } else {
      this.ingredients.update(prev => [...prev, {
        id: ing.id,
        name: ing.name,
        amount: 1,
        unit: ing.unit
      }]);
    }
    this.ingredientSearchTerm.set('');
    this.isDropdownOpen.set(false);
  }

  removeIngredient(index: number) {
    this.ingredients.update(prev => {
      const copy = [...prev];
      copy.splice(index, 1);
      return copy;
    });
  }

  saveRecipe() {
    const user = this.auth.loggedInUser();
    if (!user) {
      this.toast.show('Be kell jelentkezned!', 'error');
      return;
    }

    const formData = new FormData();
    formData.append('name', this.recipeName);
    formData.append('userId', user.id.toString());
    formData.append('description', this.recipeDescription);
    if (this.selectedFile) formData.append('image', this.selectedFile);
    formData.append('ingredients', JSON.stringify(this.ingredients()));

    this.recipeService.createRecipe(formData).subscribe({
      next: () => {
        this.toast.show('Mentve!', 'success');
        this.router.navigate(['/user-recipes']);
      },
      error: () => this.toast.show('Szerver hiba.', 'error')
    });
  }
}