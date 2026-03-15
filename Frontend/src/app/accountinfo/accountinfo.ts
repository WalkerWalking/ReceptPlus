import { Component, inject, Signal, signal } from '@angular/core';
import { AuthService } from '../auth-service';
import { User } from '../models/user.model';

@Component({
  selector: 'app-accountinfo',
  imports: [],
  templateUrl: './accountinfo.html',
  styleUrl: './accountinfo.scss',
})
export class Accountinfo {
  userData = {
    username: 'Felhasználónév',
    name: 'Minta János',
    email: 'janos@pelda.hu',
    profilePicture: 'https://this-person-does-not-exist.com/img/avatar-gen77baa837359ba27a16e6f2284b4673b3.jpg',
    birthYear: 1990,
    weight: 70,
    height: 170,
    bmi: 24.2,
    caloriesTaken: 0,
    calorieGoal: 2000
  };

  auth = inject(AuthService);

  loggedInUser !: Signal<User | null>

  ngOnInit(){
    this.loggedInUser = this.auth.loggedInUser;
  }

  resetCalories() {
    this.auth.updateUserCalories(0).subscribe(user => {
    this.auth.loggedInUser.set(user);
    localStorage.setItem("user", JSON.stringify(user));
  });
  }

}
