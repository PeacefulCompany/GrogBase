import { AfterViewInit, Component, ElementRef, ViewChild } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { debounceTime, distinctUntilChanged, filter, fromEvent, map, of, tap } from 'rxjs';
import { UiService } from '../_services/ui.service';
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
export class AdminPage implements AfterViewInit {
  @ViewChild('input') wineSearch!: ElementRef;

  wineries: Winery[] = [];
  wineFilters: SearchOptions<Wine> = {};

  @ViewChild(WineTableComponent) wineTable!: WineTableComponent;

  constructor(
    private wineryService: WineryService,
    private dialog: MatDialog,
    private ui: UiService
  ) {
    this.wineryService.getAll()
    .subscribe(res => this.wineries = res);
  }

  ngAfterViewInit(): void {
    fromEvent(this.wineSearch.nativeElement, 'keyup')
      .pipe(
        filter(Boolean),
        debounceTime(500),
        map(() => this.wineSearch.nativeElement.value)
      )
      .subscribe(val => this.wineSearched(val));
  }

  wineTypeSelected(type?: WineType) {
    this.wineFilters.type = type;
    this.wineTable.dataSource.setFilter(this.wineFilters);
  }
  wineSearched(term: string) {
    this.wineFilters.name = term;
    this.wineTable.dataSource.setFilter(this.wineFilters);
  }

  onWineAdd() {
  }

  onWineryAdd() {
    const ref = this.dialog.open(WineryEditorComponent, {
      width: "75%",
      data: {}
    });
    ref.afterClosed().subscribe(data => {
      if(!data) return;
      data.manager_id = 5;
      this.wineryService.insert(data)
      .subscribe(() => {
        this.wineTable.dataSource.getData();
        this.ui.showMessage("Winery added successfully");
      });
      console.log(data);
    })
  }
}
