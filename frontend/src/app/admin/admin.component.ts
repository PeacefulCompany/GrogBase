import { Component, ViewChild } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { WineService } from '../_services/wine.service';
import { WineryService } from '../_services/winery.service';
import { WineEditorComponent } from '../_shared/wine-editor/wine-editor.component';
import { WineryEditorComponent } from '../_shared/winery-editor/winery-editor.component';
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
    private wineryService: WineryService,
    private dialogService: MatDialog
  ) {
    this.wineryService.getAll()
    .subscribe(res => this.wineries = res);
  }

  wineTypeSelected(type?: WineType) {
    this.wineFilters.type = type;
    this.wineTable.dataSource.setFilter(this.wineFilters);
  }

  editWinery(winery: Winery) {
    const ref = this.dialogService.open(WineryEditorComponent, {
      data: winery,
      width: "75%",
      minHeight: "75%"
    });
    ref.afterClosed().subscribe(data => {
      if(!data) return;
      this.wineryService.update(data);
    })
  }
  deleteWinery(winery: Winery) {
    this.wineryService.delete(winery);
  }
}
