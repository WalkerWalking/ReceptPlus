import { CommonModule } from '@angular/common';
import { Component, inject } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { RouterLink, Router } from "@angular/router";
import { AuthService } from '../auth-service';
import { ToastService } from '../toastwindowservice';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [FormsModule, CommonModule, RouterLink],
  templateUrl: './login.html',
  styleUrl: './login.scss',
})
export class Login {
  private router = inject(Router);
  private auth = inject(AuthService);
  private toast = inject(ToastService);

  userEmail = '';
  userPassword = '';
  showPassword = false;

  showForgotPasswordModal = false;
  resetEmail = '';
  isLoading = false;

  togglePassword(): void {
    this.showPassword = !this.showPassword;
  }

  goToRegister() {
    this.router.navigate(['/register']);
  }

  loginBtnPressed() {
    this.auth.getUser(this.userEmail, this.userPassword).subscribe({
      next: (user) => {
        this.toast.show('Sikeres bejelentkezés!', 'success');
        this.router.navigate(['/home']);
      },
      error: () => this.toast.show('Hibás e-mail vagy jelszó!', 'error')
    });
  }

  toggleForgotPasswordModal(state: boolean) {
    this.showForgotPasswordModal = state;
    if (state) this.resetEmail = this.userEmail;
  }

  sendResetEmail() {
    if (!this.resetEmail || !this.resetEmail.includes('@')) {
      this.toast.show('Érvényes e-mail címet adj meg!', 'info');
      return;
    }

    this.isLoading = true;

    this.auth.checkEmailExists(this.resetEmail).subscribe({
      next: (exists) => {
        if (exists) {
          this.auth.sendPasswordResetEmail(this.resetEmail).subscribe({
            next: () => {
              this.toast.show('A visszaállító linket elküldtük!', 'success');
              this.toggleForgotPasswordModal(false);
              this.isLoading = false;
            },
            error: () => {
              this.toast.show('Szerverhiba az e-mail küldésekor.', 'error');
              this.isLoading = false;
            }
          });
        } else {
          this.toast.show('Ezzel az e-mail címmel nincs nálunk fiók.', 'error');
          this.isLoading = false;
        }
      },
      error: () => {
        this.toast.show('Nem sikerült az ellenőrzés.', 'error');
        this.isLoading = false;
      }
    });
  }
  resetSuccess = false;
}