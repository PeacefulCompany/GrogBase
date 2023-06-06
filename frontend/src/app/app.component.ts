import { Component,ViewChild  } from '@angular/core';
import { MatSidenav } from '@angular/material/sidenav';
import { UserService } from './_services/user.service';
import { UserType } from './_types/user.interface';

const LINKS = [
  {
    icon: "home",
    label: "Home",
    route: "/",
    level: [UserType.User, UserType.Critic]
  },
  {
    icon: "wine_bar",
    label: "Wines",
    route: "/wines",
    level: [UserType.User, UserType.Critic]
  },
  {
    icon: "store",
    label: "Wineries",
    route: "/wineries",
    level: [UserType.User, UserType.Critic]
  },
  {
    icon: "menu_book",
    label: "Admin",
    route: "/admin",
    level: [UserType.Manager, UserType.Admin]
  }
];

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.sass']
})

export class AppComponent {
  title = 'frontend';
  @ViewChild('sidenav') sidenav!: MatSidenav;
  isSidenavOpened = true;
  showSignout = false;

  links: any[] = [];

  constructor(
    private user: UserService
  ) {
    this.user.onUser.subscribe(user => {
      if(!user) {
        this.links = [];
        this.showSignout = false;
      }
      else {
        this.links = LINKS.filter(link => link.level.includes(this.user.currentUser.user_type))
        this.showSignout = true;
      }
    })
  }

  toggleSidenav(): void {
    this.sidenav.toggle();
    this.isSidenavOpened = !this.isSidenavOpened;
  }

  signout() {
    this.user.logout();

  }
}
