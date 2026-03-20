import { Component, inject, Signal, OnInit } from '@angular/core';
import { Router, RouterLink, RouterLinkActive } from '@angular/router';
import { AuthService } from '../auth-service';
import { ToastService } from '../toastwindowservice';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [RouterLink, RouterLinkActive, CommonModule], 
  templateUrl: './navbar.html',
  styleUrl: './navbar.scss',
})
export class Navbar implements OnInit {  
  private router = inject(Router);
  private auth = inject(AuthService);
  private toast = inject(ToastService);

  isLoggedIn: Signal<boolean> = this.auth.isLoggedIn;

  ngOnInit() {
    this.auth.restoreUser();
  }

  goToLogin() {
    this.router.navigate(['/login']);
  }

  async logout() {
    const confirmed = await this.toast.askConfirmation(
      'Kijelentkezés',
      'Biztosan el szeretnéd hagyni az alkalmazást?'
    );

    if (confirmed) {
      this.auth.logout(); 
      this.router.navigate(['/login']);
    }
  }
}