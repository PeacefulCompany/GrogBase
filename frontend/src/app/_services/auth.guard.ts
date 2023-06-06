import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, Router } from '@angular/router';
import { UserType } from '../_types/user.interface';
import { UserService } from './user.service';
import { MatSnackBar } from '@angular/material/snack-bar';

@Injectable({
  providedIn: 'root'
})
export class AuthGuard implements CanActivate {
  constructor(private userService: UserService, private router: Router, private snackBar: MatSnackBar) {}

  canActivate(route: ActivatedRouteSnapshot): boolean {
    if(!this.userService.isLoggedIn) {
      this.router.navigate(['/login']);
      this.snackBar.open('You do not have permission to access this page', 'Close', {
        duration: 3000,
      });
      return false;
    }
    const user = this.userService.currentUser;
    if(user.user_type === UserType.Admin || user.user_type === UserType.Manager) {
      if(route?.routeConfig?.path === 'admin' || route?.routeConfig?.path === 'wineries') {
        this.snackBar.open('You do not have permission to access this page', 'Close', {
          duration: 3000,
        });
        return true;
      }
      this.router.navigate(['/admin']);
      this.snackBar.open('You do not have permission to access this page', 'Close', {
        duration: 3000,
      });
      return false;
    } else {
      if(route?.routeConfig?.path === 'admin'){
        this.router.navigate(['/home']);
        this.snackBar.open('You do not have permission to access this page', 'Close', {
          duration: 3000,
        });
        return false;
      }
      return true;
    }
  }
}
