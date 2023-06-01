import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatSidenavModule } from '@angular/material/sidenav';
import { MatListModule } from '@angular/material/list';
import {MatCardModule} from '@angular/material/card';
import { HomeComponent } from './home.component';

@NgModule({
    declarations: [
        HomeComponent
    ],
    imports: [
      BrowserModule,
      BrowserAnimationsModule,
      MatToolbarModule,
      MatSidenavModule,
      MatListModule,
      RouterModule,
      MatCardModule
    ],
    providers: [],
  })
  export class HomeModule { 
  }