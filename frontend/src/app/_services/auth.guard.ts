import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, Router } from '@angular/router';
import { UserType } from '../_types/user.interface';
import { UserService } from './user.service';

@Injectable({
  providedIn: 'root'
})
export class AuthGuard implements CanActivate {
  constructor(private userService: UserService, private router: Router) {}

  canActivate(route: ActivatedRouteSnapshot): boolean {
  if (this.userService.currentUser.api_key !== null) {
      const user = this.userService.currentUser;
      if(user.user_type === UserType.Admin || user.user_type === UserType.Manager) {
        if(route?.routeConfig?.path === 'admin' || route?.routeConfig?.path === 'wineries') {
          return true;
        }
          this.router.navigate(['/admin']);
          return false;
      } else {
        if(route?.routeConfig?.path === 'admin'){
          this.router.navigate(['/home']);
          return false;
        }
        return true;
      }
    } else {
      this.router.navigate(['/login']);
      return false;
    }
  }
}
