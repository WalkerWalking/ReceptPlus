import { HttpClient } from '@angular/common/http';
import { Injectable, signal } from '@angular/core';
import { Route, Router } from '@angular/router';
import { User } from './models/user.model';
import { Observable, tap } from 'rxjs';
import { email } from '@angular/forms/signals';

@Injectable({
  providedIn: 'root',
})
export class AuthService {

  constructor(private http: HttpClient) {
    this.restoreUser();
  }

  loggedInUser = signal<User | null>(null);
  isLoggedIn = signal<boolean>(false);

  getUser(userEmail: string, userPassword: string): Observable<User> {
    return this.http.post<any>(`http://127.0.0.1:8000/api/login`, { email: userEmail, passwrd: userPassword }).pipe(
      tap((user) => {
        this.loggedInUser.set(user);
        this.isLoggedIn.set(true);
        localStorage.setItem('loggedInUser', JSON.stringify(user));
      })
    );
  }

  registerUser(user: { email: string; passwrd: string; name: string; username: string; }): Observable<any> {
    return this.http.post<any>(`http://127.0.0.1:8000/api/register`, user);
  }

  restoreUser(): void {
    const savedUser = localStorage.getItem('loggedInUser');

    if (savedUser) {
      const user: User = JSON.parse(savedUser);
      this.loggedInUser.set(user);
      this.isLoggedIn.set(true);
    } else {
      this.loggedInUser.set(null);
      this.isLoggedIn.set(false);
    }
  }

  logout(): void {
    localStorage.removeItem('loggedInUser');
    this.loggedInUser.set(null);
    this.isLoggedIn.set(false);
  }

  updateUserCalories(calories: number) {
  return this.http.put<any>(
    `http://127.0.0.1:8000/api/users/updateCalories/${this.loggedInUser()?.id}`,
    { caloriesEaten: calories }
  );
}



}
