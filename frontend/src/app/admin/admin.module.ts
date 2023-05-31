import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { AdminRoutingModule } from './admin-routing.module';
import { AdminPage } from './admin.component';
import { WineryComponent } from './winery/winery.component';

import { MatCardModule } from "@angular/material/card";
import { MatButtonModule } from "@angular/material/button";
import { MatListModule } from "@angular/material/list";
import { MatIconModule } from "@angular/material/icon";
import { MatTableModule } from "@angular/material/table";
import { MatDialogModule } from "@angular/material/dialog";


@NgModule({
  declarations: [
    AdminPage,
    WineryComponent
  ],
  imports: [
    CommonModule,
    AdminRoutingModule,

    MatCardModule,
    MatButtonModule,
    MatListModule,
    MatIconModule,
    MatTableModule,
    MatDialogModule
  ]
})
export class AdminModule { }
