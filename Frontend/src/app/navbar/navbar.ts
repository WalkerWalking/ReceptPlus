import { Component, Signal } from '@angular/core';
import { Router, RouterLink, RouterLinkActive } from '@angular/router'; // Kell a navigációhoz
import { AuthService } from '../auth-service';
import { User } from '../models/user.model';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [RouterLink, RouterLinkActive], // RouterLink-et használd href helyett
  templateUrl: './navbar.html',
  styleUrl: './navbar.scss',
})
export class Navbar {  

  constructor(private router: Router, private auth: AuthService) {}

  isLoggedIn!:Signal<boolean>;

  ngOnInit() {
    this.isLoggedIn = this.auth.isLoggedIn;
  }

  goToLogin() {
    this.router.navigate(['/login']);
  }

  logout() {
    this.auth.logout();
    this.router.navigate(['/login']);
  }
}