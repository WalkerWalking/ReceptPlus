import { Component } from '@angular/core';
import { RecipeService } from '../recipe.service';
import { Router } from '@angular/router';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-searchbar',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './searchbar.html',
  styleUrl: './searchbar.scss',
})
export class Searchbar {
  constructor(public recipeService: RecipeService, private router: Router) { }

  onSearchChange(event: Event) {
    const value = (event.target as HTMLInputElement).value;
    this.recipeService.setSearchTerm(value);

    if (value.length >= 3) {
      if (this.router.url !== '/all-recipes') {
        this.router.navigate(['/all-recipes']);
      }
    }
  }
}