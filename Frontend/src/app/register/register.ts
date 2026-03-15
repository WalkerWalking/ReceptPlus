import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { RouterLink } from "@angular/router";
import { Router } from '@angular/router';
import { AuthService } from '../auth-service';

@Component({
  selector: 'app-register',
  imports: [FormsModule, CommonModule, RouterLink],
  templateUrl: './register.html',
  styleUrl: './register.scss',
})
export class Register {

  constructor(private router: Router, private auth:AuthService) { }


  showPassword = false;
  showConfirmPassword = false;

  togglePassword(): void {
    this.showPassword = !this.showPassword;
    this.showConfirmPassword = !this.showConfirmPassword;

  }

  profileImageUrl: string | null = null;

  onFileSelected(event: any) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = () => {
        this.profileImageUrl = reader.result as string;
      };
      reader.readAsDataURL(file);
    }
  }

  goToLogin() {
    this.router.navigate(['/login']);
  }

  name:string = "";
  userName:string = "";
  email:string = "";
  password:string = "";  

  registerButtonPressed(){
    this.auth.registerUser({email: this.email, passwrd: this.password, name: this.name, username: this.userName}).subscribe({
      next: (response) => {        
        this.auth.loggedInUser.set(response.user);
        this.auth.isLoggedIn.set(true);
        this.router.navigate(['/loggedin']);
      },
      error: (error) => {
        alert(error.message);
      }
    });
  }
}
