import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { WineriesRoutingModule } from './wineries-routing.module';
import { WineriesPage } from './wineries.component';
import { SharedModule } from '../_shared/shared.module';
import { MatSelectModule } from '@angular/material/select';


@NgModule({
  declarations: [
    WineriesPage
  ],
  imports: [
    CommonModule,
    WineriesRoutingModule,

    MatSelectModule,

    SharedModule
  ]
})
export class WineriesModule { }
