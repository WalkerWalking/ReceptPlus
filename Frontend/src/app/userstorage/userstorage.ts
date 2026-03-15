import { Component, DOCUMENT, inject, signal, Signal } from '@angular/core';
import { CommonModule, UpperCasePipe } from '@angular/common';
import { FormsModule } from '@angular/forms'; // <-- Fontos az átíráshoz
import { UserStorageService } from '../user-storage-service';
import { UserIngredient } from '../models/userIngredient.model';
import { Router } from '@angular/router';

@Component({
  selector: 'app-userstorage',
  standalone: true,
  imports: [CommonModule, UpperCasePipe, FormsModule],
  templateUrl: './userstorage.html',
  styleUrl: './userstorage.scss',
})
export class Userstorage {

  private userStorageService = inject(UserStorageService);
  
  ingredients ?: Signal<UserIngredient[]>;

  ngOnInit(): void {
    this.userStorageService.getUserIngredients();
    this.ingredients = this.userStorageService.userIngredients
  }
  

  // Dinamikus mértékegység és érték kijelzés
  getFormattedAmount(item: UserIngredient): string {
    if (item.unit === 'db') {
      return `${item.amount} DB`;
    }
    
    if (item.unit === 'g') {
      return item.amount >= 1000 
        ? `${(item.amount / 1000).toFixed(1)} KG` 
        : `${item.amount} G`;
    }

    if (item.unit === 'ml') {
      return item.amount >= 1000 
        ? `${(item.amount / 1000).toFixed(1)} L` 
        : `${item.amount} ML`;
    }

    return `${item.amount} ${item.unit}`;
  }

  deleteItem(id:number){
    this.userStorageService.deleteIngredient(id);    
  }
}