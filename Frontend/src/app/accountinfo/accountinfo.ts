import { Component, inject, signal } from '@angular/core';
import { AuthService } from '../auth-service';
import { HttpClient } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { ToastService } from '../toastwindowservice';

@Component({
  selector: 'app-accountinfo',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './accountinfo.html',
  styleUrl: './accountinfo.scss',
})
export class Accountinfo {
  private auth = inject(AuthService);
  private http = inject(HttpClient);
  private router = inject(Router);
  private toast = inject(ToastService);

  loggedInUser = this.auth.loggedInUser;

  birthDate = "";
  bodyweight = 0;
  height = 0;

  constructor() {
    this.auth.restoreUser();
  }

  resetCalories() {
    this.auth.updateUserCalories(0).subscribe(user => {
      this.auth.setLoggedInUser(user);
    });
  }

  getBmiClass(): string {
    const bmi = this.loggedInUser()?.bmi;
    if (!bmi) return 'text-secondary';
    if (bmi < 18.5) return 'text-warning';
    if (bmi >= 18.5 && bmi < 25) return 'text-success';
    if (bmi >= 25 && bmi < 30) return 'text-warning';
    return 'text-danger';
  }

  fileInputClick(fileInput: HTMLInputElement) {
    fileInput.click();
  }

  onFileSelected(event: any) {
    const file = event.target.files[0];
    if (!file) return;

    const user = this.loggedInUser();
    if (!user) {
      this.toast.show('Nincs bejelentkezett felhasználó', 'error');
      return;
    }

    const formData = new FormData();
    formData.append('image', file);
    formData.append('userId', user.id.toString());

    this.http.post<any>('http://127.0.0.1:8000/api/uploadProfileImage', formData)
      .subscribe({
        next: (res) => {
          this.auth.setLoggedInUser(res.user);
          this.toast.show(res.message || 'Profilkép sikeresen frissítve!', 'success');
        },
        error: (err) => {
          this.toast.show(err?.error?.message ?? 'Hiba történt a képfeltöltés során', 'error');
        }
      });
  }

  updateUserData() {
    const user = this.loggedInUser();

    if (!user) {
      this.toast.show("Nincs bejelentkezett felhasználó!", "error");
      return;
    }

    const data = {
      birthDate: this.birthDate,
      bodyweightKg: this.bodyweight,
      heightCm: this.height
    };

    this.http.put<any>(`http://127.0.0.1:8000/api/users/updateProfile/${user.id}`, data)
      .subscribe({
        next: (res) => {
          this.auth.setLoggedInUser(res.user);
          this.toast.show(res.message || "Adatok sikeresen frissítve!", "success");
        },
        error: (err) => {
          this.toast.show(err?.error?.message ?? "Nem sikerült frissíteni az adatokat", "error");
        }
      });
  }

  async deleteUser() {
    const user = this.loggedInUser();
    if (!user) return;

    const confirmed = await this.toast.askConfirmation(
      "Profil törlése",
      "Biztosan törölni szeretnéd a fiókodat? Ez a művelet nem vonható vissza!"
    );

    if (confirmed) {
      this.auth.deleteUser(user.id).subscribe({
        next: (response) => {
          this.router.navigate(['/login']);
        },
        error: (err) => {
          console.error("Törlési hiba az AccountInfo-ban", err);
        }
      });
    }
  }
}