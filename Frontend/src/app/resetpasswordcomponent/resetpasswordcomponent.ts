import { Component, OnInit, inject } from '@angular/core';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { AuthService } from '../auth-service';
import { ToastService } from '../toastwindowservice';

@Component({
  selector: 'app-reset-password',
  standalone: true,
  imports: [FormsModule, CommonModule, RouterLink],
  templateUrl: './resetpasswordcomponent.html',
  styleUrl: './resetpasswordcomponent.scss',
})
export class Resetpasswordcomponent implements OnInit {
  private route = inject(ActivatedRoute);
  private router = inject(Router);
  private authService = inject(AuthService);
  private toast = inject(ToastService);

  email: string = '';
  token: string = '';
  
  newPassword: string = '';
  confirmPassword: string = '';
  
  isLoading: boolean = false;
  showPassword: boolean = false;

  ngOnInit() {
    this.token = this.route.snapshot.queryParamMap.get('token') || '';
    this.email = this.route.snapshot.queryParamMap.get('email') || '';

    if (!this.token || !this.email) {
      this.toast.show('Érvénytelen vagy hiányzó visszaállító link!', 'error');
      this.router.navigate(['/login']);
    }
  }

  confirmReset() {
    if (this.newPassword.length < 6) {
      this.toast.show('A jelszónak legalább 6 karakternek kell lennie!', 'info');
      return;
    }

    if (this.newPassword !== this.confirmPassword) {
      this.toast.show('A két jelszó nem egyezik!', 'error');
      return;
    }

    this.isLoading = true;

    this.authService.resetPassword(this.email, this.token, this.newPassword).subscribe({
      next: (res) => {
        this.isLoading = false;
        this.toast.show('A jelszavad sikeresen megváltozott!', 'success');
        this.router.navigate(['/login']);
      },
      error: (err) => {
        this.isLoading = false;
        const hibaUzenet = err.error?.message || 'Hiba történt a mentés során.';
        this.toast.show(hibaUzenet, 'error');
      }
    });
  }
}