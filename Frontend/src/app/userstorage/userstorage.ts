import { Component, OnInit, inject, signal, computed, HostListener } from '@angular/core';
import { CommonModule, UpperCasePipe } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { UserStorageService } from '../user-storage-service';
import { RecipeService } from '../recipe.service';
import { UserIngredient } from '../models/userIngredient.model';
import { Ingredient } from '../models/ingredient.model';
import { AuthService } from '../auth-service';
import { ToastService } from '../toastwindowservice';

@Component({
  selector: 'app-userstorage',
  standalone: true,
  imports: [CommonModule, UpperCasePipe, FormsModule],
  templateUrl: './userstorage.html',
  styleUrls: ['./userstorage.scss'],
})
export class Userstorage implements OnInit {
  private userStorageService = inject(UserStorageService);
  private recipeService = inject(RecipeService);
  private auth = inject(AuthService);
  private toastService = inject(ToastService);

  public allIngredientsSignal = this.userStorageService.userIngredients;
  searchTerm = signal('');

  private availableIngredients = signal<Ingredient[]>([]);
  ingredientSearchQuery = signal(''); 
  isDropdownOpen = signal(false);
  selectedIngredient = signal<Ingredient | null>(null);
  amount: number | undefined = undefined;

  filteredAvailableIngredients = computed(() => {
    const term = this.ingredientSearchQuery().toLowerCase().trim();
    if (!term) return this.availableIngredients();
    return this.availableIngredients().filter(ing => 
      ing.name.toLowerCase().includes(term)
    );
  });

  filteredUserIngredients = computed(() => {
    const term = this.searchTerm().toLowerCase().trim();
    const items = this.allIngredientsSignal();
    if (!term) return items;
    return items.filter(item => item.name.toLowerCase().includes(term));
  });

  @HostListener('document:click', ['$event'])
  onClickOutside(event: Event) {
    const target = event.target as HTMLElement;
    if (!target.closest('.custom-select-container')) {
      this.isDropdownOpen.set(false);
    }
  }

  ngOnInit(): void {
    this.userStorageService.getUserIngredients();
    this.recipeService.getIngredients().subscribe({
      next: (res) => this.availableIngredients.set(res),
      error: (err) => console.error('Hiba az alapanyagok betöltésekor', err)
    });
  }

  selectIngredient(ing: Ingredient) {
    this.selectedIngredient.set(ing);
    this.ingredientSearchQuery.set(ing.name);
    setTimeout(() => {
      this.isDropdownOpen.set(false);
    }, 50);
  }

  addIngredient() {
    const user = this.auth.loggedInUser();
    const ingredient = this.selectedIngredient();

    if (!user || !ingredient || (this.amount ?? 0) <= 0) {
      this.toastService.show('Kérlek válassz alapanyagot és érvényes mennyiséget!', 'info');
      return;
    }

    this.userStorageService
      .addIngredientByName(user.id, ingredient.name, this.amount ?? 0)
      .subscribe({
        next: () => {
          this.selectedIngredient.set(null);
          this.ingredientSearchQuery.set('');
          this.amount = undefined;
        },
        error: (err) => console.error('Hozzáadási hiba:', err)
      });
  }

  async deleteItem(id: number) {
    const itemToDelete = this.allIngredientsSignal().find(i => i.id === id);
    const confirmed = await this.toastService.askConfirmation(
      'Alapanyag törlése',
      `Biztosan ki akarod törölni a raktáradból: ${itemToDelete?.name}?`
    );

    if (confirmed) {
      this.userStorageService.deleteIngredient(id);
    }
  }

  getFormattedAmount(item: UserIngredient): string {
    if (item.unit === 'db') return `DB`;
    if (item.unit === 'g') return item.amount >= 1000 ? `KG` : `G`;
    if (item.unit === 'ml') return item.amount >= 1000 ? `L` : `ML`;
    return item.unit;
  }

  getDisplayAmount(item: UserIngredient): string {
    if ((item.unit === 'g' || item.unit === 'ml') && item.amount >= 1000) {
      return (item.amount / 1000).toFixed(1);
    }
    return item.amount.toString();
  }
}