import { Injectable, signal, inject } from '@angular/core';
import { UserIngredient } from './models/userIngredient.model';
import { HttpClient } from '@angular/common/http';
import { catchError, map, Observable, switchMap, tap, throwError } from 'rxjs';
import { AuthService } from './auth-service';
import { Ingredient } from './models/ingredient.model';
import { ToastService } from './toastwindowservice';

@Injectable({
  providedIn: 'root',
})
export class UserStorageService {
  private http = inject(HttpClient);
  private auth = inject(AuthService);
  private toast = inject(ToastService);

  private _userIngredients = signal<UserIngredient[]>([]);
  userIngredients = this._userIngredients.asReadonly();

  constructor() { }


  setUserIngredients(ingredients: UserIngredient[]) {
    this._userIngredients.set(ingredients);
  }

  getUserIngredients() {
    const userId = this.auth.loggedInUser()?.id;
    if (!userId) return;

    this.http.get<any[]>(`http://127.0.0.1:8000/api/users/${userId}/ingredients`)
      .pipe(
        map(response =>
          response.map(item => ({
            id: item.ingredientId,
            name: item.ingredient.name,
            amount: item.amount,
            unit: item.ingredient.unit
          }))
        ),
        catchError(err => {
          console.error('Raktár hiba:', err);
          return throwError(() => err);
        })
      )
      .subscribe(data => {
        this._userIngredients.set(data);
      });
  }

  getIngredientByName(name: string): Observable<Ingredient> {
    return this.http.get<Ingredient>(
      `http://127.0.0.1:8000/api/ingredients/getByName/${name}`
    );
  }

  storeUserIngredient(data: { userId: number; ingredientId: number; amount: number }): Observable<any> {
    return this.http.post<any>('http://127.0.0.1:8000/api/usersIngredients', data);
  }

  addIngredientByName(userId: number, ingredientName: string, amount: number): Observable<any> {
    return this.getIngredientByName(ingredientName).pipe(
      switchMap((ingredient: Ingredient) =>
        this.storeUserIngredient({
          userId: userId,
          ingredientId: ingredient.id,
          amount: amount
        })
      ),
      tap(() => {
        this.toast.show(`${ingredientName} hozzáadva a raktárhoz!`, 'success');
        this.getUserIngredients();
      }),
      catchError(err => {
        this.toast.show('Nem sikerült hozzáadni az alapanyagot.', 'error');
        return throwError(() => err);
      })
    );
  }


  deleteIngredient(ingredientId: number) {
    const userId = this.auth.loggedInUser()?.id;
    if (!userId) return;

    this.http.delete(`http://127.0.0.1:8000/api/usersIngredients/${userId}/${ingredientId}`)
      .subscribe({
        next: () => {
          this.toast.show('Alapanyag eltávolítva.', 'info');
          const currentIngredients = this._userIngredients();
          this._userIngredients.set(currentIngredients.filter(i => i.id !== ingredientId));
        },
        error: (err) => {
          this.toast.show('Hiba történt a törlés során.', 'error');
          console.error(err);
        }
      });
  }
}