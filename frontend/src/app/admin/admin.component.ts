import { Component } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { WineService } from '../_services/wine.service';
import { WineryService } from '../_services/winery.service';
import { WineryEditorComponent } from '../_shared/winery-editor/winery-editor.component';
import { Winery, Wine } from '../_types';

@Component({
  selector: 'app-admin',
  templateUrl: './admin.component.html',
  styleUrls: ['./admin.component.sass']
})
export class AdminPage {
  wineries: Winery[] = [];
  wines: Wine[] = [];

  constructor(
    private wineryService: WineryService,
    private wineService: WineService,
    private dialogService: MatDialog
  ) {
    this.wineryService.getAll()
    .subscribe(res => this.wineries = res);
    this.wineService.getAll()
    .subscribe(res => this.wines = res);
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

  editWine(wine: Wine) {
    alert("edit: " + wine.id);
  }
  deleteWine(wine: Wine) {
    alert("delete: " + wine.id);
  }
}
