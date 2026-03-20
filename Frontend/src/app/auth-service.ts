import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Injectable, signal, inject } from '@angular/core';
import { User } from './models/user.model';
import { Observable, tap, catchError, throwError, map } from 'rxjs';
import { ToastService } from './toastwindowservice';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private http = inject(HttpClient);
  private toast = inject(ToastService);
  private readonly API_URL = 'http://127.0.0.1:8000/api';

  loggedInUser = signal<User | null>(null);
  isLoggedIn = signal<boolean>(false);

  constructor() {
    this.restoreUser();
  }

  checkEmailExists(email: string): Observable<boolean> {
    return this.http.post<{ exists: boolean }>(`${this.API_URL}/check-email`, { email }).pipe(
      map(res => res.exists),
      catchError((err) => {
        console.error('Email ellenőrzési hiba:', err);
        return throwError(() => err);
      })
    );
  }

  sendPasswordResetEmail(email: string): Observable<any> {
    return this.http.post(`${this.API_URL}/forgot-password`, { email }).pipe(
      tap(() => { }),
      catchError((err: HttpErrorResponse) => {
        this.toast.show('Hiba történt a levél küldésekor!', 'error');
        return throwError(() => err);
      })
    );
  }

  resetPassword(email: string, token: string, passwrd: string) {
    return this.http.post(`${this.API_URL}/reset-password`, { email, token, passwrd });
  }


  getUser(userEmail: string, userPassword: string): Observable<User> {
    return this.http.post<any>(`${this.API_URL}/login`, { email: userEmail, passwrd: userPassword }).pipe(
      tap((user) => {
        this.loggedInUser.set(user);
        this.isLoggedIn.set(true);
        localStorage.setItem('loggedInUser', JSON.stringify(user));
        this.toast.show(`Üdv újra, ${user.username}!`, 'success');
      }),
      catchError((err: HttpErrorResponse) => {
        let errorMessage = 'Hiba a bejelentkezésnél!';
        if (err.status === 401) errorMessage = 'Hibás email cím vagy jelszó!';
        else if (err.status === 404) errorMessage = 'Nincs ilyen felhasználó!';
        else if (err.status === 0) errorMessage = 'A szerver nem elérhető!';

        this.toast.show(errorMessage, 'error');
        return throwError(() => err);
      })
    );
  }

  registerUser(user: { email: string; passwrd: string; name: string; username: string; }): Observable<any> {
    return this.http.post<any>(`${this.API_URL}/register`, user).pipe(
      tap(() => this.toast.show('Sikeres regisztráció!', 'success')),
      catchError((err: HttpErrorResponse) => {
        let errorMessage = 'A regisztráció nem sikerült.';
        if (err.status === 422) errorMessage = 'Ez az email vagy felhasználónév már foglalt!';
        this.toast.show(errorMessage, 'error');
        return throwError(() => err);
      })
    );
  }

  logout(): void {
    localStorage.removeItem('loggedInUser');
    this.loggedInUser.set(null);
    this.isLoggedIn.set(false);
    this.toast.show('Sikeresen kijelentkeztél.', 'info');
  }

  updateUserCalories(calories: number) {
    return this.http.put<User>(
      `${this.API_URL}/users/updateCalories/${this.loggedInUser()?.id}`,
      { caloriesEaten: calories }
    ).pipe(
      tap(() => this.toast.show('Kalória bevitel frissítve!', 'success')),
      catchError((err) => {
        this.toast.show('Nem sikerült a kalória mentése.', 'error');
        return throwError(() => err);
      })
    );
  }

  deleteUser(userId: number) {
    return this.http.delete<any>(`${this.API_URL}/users/${userId}`).pipe(
      tap(() => {
        this.logout();
        this.toast.show('Profilod véglegesen törölve lett.', 'info');
      }),
      catchError((err) => {
        this.toast.show('Hiba történt a törlés közben.', 'error');
        return throwError(() => err);
      })
    );
  }

  restoreUser(): void {
    const savedUser = localStorage.getItem('loggedInUser');
    if (savedUser) {
      const user: User = JSON.parse(savedUser);
      this.setLoggedInUser(user);
      this.isLoggedIn.set(true);
    }
  }

  setLoggedInUser(user: User) {
    const updatedUser = this.calculateMetrics(user);
    this.loggedInUser.set(updatedUser);
    localStorage.setItem('loggedInUser', JSON.stringify(updatedUser));
  }

  calculateMetrics(user: User): User {
    if (!user.bodyweightKg || !user.heightCm) return user;
    const heightMeter = user.heightCm / 100;
    const bmi = Number((user.bodyweightKg / (heightMeter * heightMeter)).toFixed(1));
    const calorieGoal = Math.round(user.bodyweightKg * 30);
    return { ...user, bmi, calorieGoal };
  }
}