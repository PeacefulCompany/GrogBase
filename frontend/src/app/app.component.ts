import { Component,ViewChild  } from '@angular/core';
import { MatSidenav } from '@angular/material/sidenav';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.sass']
})
export class AppComponent {
  title = 'frontend';
  @ViewChild('sidenav') sidenav!: MatSidenav;
  isSidenavOpened = true;

  toggleSidenav(): void {
    this.sidenav.toggle();
    this.isSidenavOpened = !this.isSidenavOpened;
  }
}
