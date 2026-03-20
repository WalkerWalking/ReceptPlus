import { CommonModule } from '@angular/common';
import { Component, inject } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { RouterLink, Router } from "@angular/router";
import { AuthService } from '../auth-service';
import { ToastService } from '../toastwindowservice';

@Component({
  selector: 'app-register',
  standalone: true,
  imports: [FormsModule, CommonModule, RouterLink],
  templateUrl: './register.html',
  styleUrl: './register.scss',
})
export class Register {
  private router = inject(Router);
  private auth = inject(AuthService);
  private toast = inject(ToastService);

  showPassword = false;

  name: string = "";
  userName: string = "";
  email: string = "";
  password: string = "";
  confirmPassword: string = "";

  togglePassword(): void {
    this.showPassword = !this.showPassword;
  }

  goToLogin() {
    this.router.navigate(['/login']);
  }

  registerButtonPressed() {
    if (!this.email || !this.password || !this.userName) {
      this.toast.show('Kérjük, tölts ki minden kötelező mezőt!', 'info');
      return;
    }

    if (this.password !== this.confirmPassword) {
      this.toast.show('A két jelszó nem egyezik!', 'error');
      return;
    }

    if (this.password.length < 6) {
      this.toast.show('A jelszónak legalább 6 karakternek kell lennie!', 'info');
      return;
    }

    this.auth.registerUser({ 
      email: this.email, 
      passwrd: this.password, 
      name: this.name, 
      username: this.userName 
    }).subscribe({
      next: (response) => {
        this.auth.setLoggedInUser(response);
        this.auth.isLoggedIn.set(true);
        this.toast.show('Sikeres regisztráció! Üdvözlünk!', 'success');
        this.router.navigate(['']);
      },
      error: (error) => {
        this.toast.show('Nem sikerült a regisztráció!', 'error');
        console.error('Regisztrációs hiba:', error);
      }
    });
  }
}