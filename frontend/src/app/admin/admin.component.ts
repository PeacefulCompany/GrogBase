import { Component, ViewChild } from '@angular/core';
import { MatSort, Sort } from '@angular/material/sort';
import { WineryService } from '../_services/winery.service';
import { Winery } from '../_types';

@Component({
  selector: 'app-admin',
  templateUrl: './admin.component.html',
  styleUrls: ['./admin.component.sass']
})
export class AdminPage {
  wineries: Winery[] = [];
  @ViewChild(MatSort) sort!: MatSort;

  constructor(private wineryService: WineryService) {
    this.wineryService.getAll()
    .subscribe(res => this.wineries = res);
  }
  onSort(sortState: any) {
    sortState = sortState as Sort;
    alert(sortState.direction);
  }
}
