import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, Router } from '@angular/router';
import { UserType } from '../_types/user.interface';
import { UserService } from './user.service';
import { MatSnackBar } from '@angular/material/snack-bar';
import { UiService } from './ui.service';

@Injectable({
  providedIn: 'root'
})
export class AuthGuard implements CanActivate {
  constructor(
    private userService: UserService,
    private router: Router,
    private ui: UiService
  ) {}

  canActivate(route: ActivatedRouteSnapshot): boolean {
    if(!this.userService.isLoggedIn) {
      this.router.navigate(['/login']);
      this.ui.showMessage('You do not have permission to access this page');
      return false;
    }
    const user = this.userService.currentUser;
    if(user.user_type === UserType.Admin || user.user_type === UserType.Manager) {
      if(route?.routeConfig?.path === 'admin' || route?.routeConfig?.path === 'wineries') {
        this.ui.showError('You do not have permission to access this page');
        return true;
      }
      this.router.navigate(['/admin']);
      this.ui.showError('You do not have permission to access this page');
      return false;
    } else {
      if(route?.routeConfig?.path === 'admin'){
        this.router.navigate(['/home']);
        this.ui.showError('You do not have permission to access this page');
        return false;
      }
      return true;
    }
  }
}
