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
import { SharedModule } from '../_shared/shared.module';
import { WineComponent } from './wine/wine.component';
import { WineTableComponent } from './wine-table/wine-table.component';
import { MatPaginatorModule } from '@angular/material/paginator';
import { MatSortModule } from '@angular/material/sort';
import { MatSelectModule } from '@angular/material/select';


@NgModule({
  declarations: [
    AdminPage,
    WineryComponent,
    WineComponent,
    WineTableComponent
  ],
  imports: [
    CommonModule,
    AdminRoutingModule,

    SharedModule,

    MatCardModule,
    MatButtonModule,
    MatListModule,
    MatIconModule,
    MatTableModule,
    MatDialogModule,
    MatPaginatorModule,
    MatSortModule,
    MatSelectModule
  ]
})
export class AdminModule { }
