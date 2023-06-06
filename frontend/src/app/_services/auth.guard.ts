import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, Router } from '@angular/router';
import { UserType } from '../_types/user.interface';
import { UserService } from './user.service';
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
      return false;
    }
    const user = this.userService.currentUser;
    if(user.user_type === UserType.Admin || user.user_type === UserType.Manager) {
      if(route?.routeConfig?.path === 'admin') {
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
  }
}
