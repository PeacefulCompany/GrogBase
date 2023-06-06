import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatSidenavModule } from '@angular/material/sidenav';
import { MatListModule } from '@angular/material/list';
import { MatCardModule} from '@angular/material/card';
import { WinePage } from './wines.component';
import { SharedModule } from '../_shared/shared.module';
import { MatSelectModule } from '@angular/material/select';
import { MatFormFieldModule } from '@angular/material/form-field';


@NgModule({
    declarations: [
        WinePage
    ],
    imports: [
      BrowserModule,
      BrowserAnimationsModule,
      RouterModule,

      SharedModule,

      MatCardModule,
      MatToolbarModule,
      MatSidenavModule,
      MatListModule,
      MatSelectModule,
      MatFormFieldModule
    ],
    providers: [],
  })
  export class WineModule {
  }
