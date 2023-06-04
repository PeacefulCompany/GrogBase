import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, Router } from '@angular/router';
import { UserService } from './user.service';

@Injectable({
  providedIn: 'root'
})
export class AuthGuard implements CanActivate {
  constructor(private userService: UserService, private router: Router) {}

  canActivate(route: ActivatedRouteSnapshot): boolean {
  if (this.userService.currentUser.api_key !== null) {
      const user = this.userService.currentUser;
      if (user && user.user_type === 'admin') {
        return true; // admin can access any page
      } else {
        if (route?.routeConfig?.path === 'admin') {
          this.router.navigate(['/home']);
          return false;
        }else{
          return true;
        }
        //implement else ifs for other user types and other pages
      }
    } else {
      this.router.navigate(['/login']);
      return false;
    }
  }

}
