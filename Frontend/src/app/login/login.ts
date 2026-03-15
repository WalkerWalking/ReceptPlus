import { CommonModule } from '@angular/common';
import { Component, Signal } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { RouterLink } from "@angular/router";
import { Router } from '@angular/router';
import { AuthService } from '../auth-service';
import { User } from '../models/user.model';
import { Observable } from 'rxjs';
@Component({
  selector: 'app-login',
  imports: [FormsModule, CommonModule, RouterLink],
  templateUrl: './login.html',
  styleUrl: './login.scss',
})
export class Login {

  constructor(private router: Router, private auth: AuthService) { }

  showPassword = false;

  togglePassword(): void {
    this.showPassword = !this.showPassword;
  }

  goToRegister() {
    console.log('Gomb megnyomva!');
    this.router.navigate(['/register']);
  }

  userEmail: string = '';
  userPassword: string = '';

  loginBtnPressed() {
  this.auth.getUser(this.userEmail, this.userPassword).subscribe({
    next: (user) => {
      console.log('Sikeres bejelentkezés', user);
      this.router.navigate(['/home']);
    },
    error: (err) => {
      console.log('Hibás email vagy jelszó', err);
    }
  });
}

}
