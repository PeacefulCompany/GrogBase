import { Component,ViewChild  } from '@angular/core';
import { MatSidenav } from '@angular/material/sidenav';
import { UserService } from './_services/user.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.sass']
})

export class AppComponent {
  title = 'frontend';
  @ViewChild('sidenav') sidenav!: MatSidenav;
  isSidenavOpened = true;

  constructor(
    private user: UserService
  ) {
  }

  toggleSidenav(): void {
    this.sidenav.toggle();
    this.isSidenavOpened = !this.isSidenavOpened;
  }

  signout() {
    this.user.logout();

  }
}
