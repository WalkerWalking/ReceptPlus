import { Injectable, inject } from '@angular/core';
import { CanActivate, Router, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { ToastService } from './toastwindowservice';

@Injectable({
  providedIn: 'root',
})
export class AuthguardService {
  private toast = inject(ToastService);
  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean {
    const loggedInUser = localStorage.getItem('loggedInUser');

    if (loggedInUser) {
      return true;
    } else {
      this.toast.show("A funkció eléréséhez jelentkezz be!",'error');
      this.router.navigate(['/']);
      return false;
    }
  }

  constructor(private router: Router) { }
}
