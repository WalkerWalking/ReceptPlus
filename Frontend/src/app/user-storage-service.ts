import { Injectable, numberAttribute, signal } from '@angular/core';
import { UserIngredient } from './models/userIngredient.model';
import { HttpClient } from '@angular/common/http';
import { map } from 'rxjs';
import { AuthService } from './auth-service';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root',
})
export class UserStorageService {

  constructor(private http: HttpClient, private auth: AuthService, private router: Router) { }

  private _userIngredients = signal<UserIngredient[]>([]);
  userIngredients = this._userIngredients.asReadonly();

  setUserIngredients(ingredients: UserIngredient[]) {
    this._userIngredients.set(ingredients);
  }

  getUserIngredients() {
    this.http.get<any[]>(`http://127.0.0.1:8000/api/users/${this.auth.loggedInUser()?.id}/ingredients`)
      .pipe(
        map(response =>
          response.map(item => ({
            id: item.ingredientId,
            name: item.ingredient.name,
            amount: item.amount,
            unit: item.ingredient.unit
          }))
        )
      )
      .subscribe(data => {
        this._userIngredients.set(data);
      });
  }

  deleteIngredient(ingredientId: number) {
    this.http.delete(`http://127.0.0.1:8000/api/usersIngredients/${this.auth.loggedInUser()?.id}/${ingredientId}`).subscribe(event => {
      window.location.reload()
    })
  }


}
