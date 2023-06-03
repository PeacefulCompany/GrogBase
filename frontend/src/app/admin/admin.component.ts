import { Component, ViewChild } from '@angular/core';
import { WineryService } from '../_services/winery.service';
import { Winery, Wine, WineType, SearchOptions } from '../_types';
import { WineTableComponent } from './wine-table/wine-table.component';

@Component({
  selector: 'app-admin',
  templateUrl: './admin.component.html',
  styleUrls: ['./admin.component.sass']
})
export class AdminPage {
  wineries: Winery[] = [];
  wineFilters: SearchOptions<Wine> = {};

  @ViewChild(WineTableComponent) wineTable!: WineTableComponent;

  constructor(
    private wineryService: WineryService
  ) {
    this.wineryService.getAll()
    .subscribe(res => this.wineries = res);
  }

  wineTypeSelected(type?: WineType) {
    this.wineFilters.type = type;
    this.wineTable.dataSource.setFilter(this.wineFilters);
  }

}
