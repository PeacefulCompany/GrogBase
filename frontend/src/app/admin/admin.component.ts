import { AfterViewInit, Component, ElementRef, ViewChild } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { debounceTime, filter, fromEvent, map } from 'rxjs';
import { UiService } from '../_services/ui.service';
import { WineryService } from '../_services/winery.service';
import { WineryEditorComponent } from '../_shared/winery-editor/winery-editor.component';
import { Winery, Wine, WineType, SearchOptions } from '../_types';
import { WineryTableComponent } from './winery-table/winery-table.component';
import { WineTableComponent } from './wine-table/wine-table.component';
import { WineEditorComponent } from '../_shared/wine-editor/wine-editor.component';
import { WineService } from '../_services/wine.service';

@Component({
  selector: 'app-admin',
  templateUrl: './admin.component.html',
  styleUrls: ['./admin.component.sass']
})
export class AdminPage implements AfterViewInit {
  @ViewChild('input') wineSearch!: ElementRef;
  @ViewChild('winerySearch') winerySearch!: ElementRef;

  wineFilters: SearchOptions<Wine> = {};
  wineryFilters: SearchOptions<Winery> = {};

  @ViewChild(WineTableComponent) wineTable!: WineTableComponent;
  @ViewChild(WineryTableComponent) wineryTable!: WineryTableComponent;

  constructor(
    private wineService: WineService,
    private wineryService: WineryService,
    private dialog: MatDialog,
    private ui: UiService
  ) {
  }

  ngAfterViewInit(): void {
    this.wineTable.dataSource.getData();

    fromEvent(this.wineSearch.nativeElement, 'keyup')
      .pipe(
        filter(Boolean),
        debounceTime(500),
        map(() => this.wineSearch.nativeElement.value)
      )
      .subscribe(val => this.wineSearched(val));
    fromEvent(this.winerySearch.nativeElement, 'keyup')
      .pipe(
        filter(Boolean),
        debounceTime(500),
        map(() => this.winerySearch.nativeElement.value)
      )
      .subscribe(val => this.winerySearched(val));
  }

  wineTypeSelected(type?: WineType) {
    this.wineFilters.type = type;
    this.wineTable.dataSource.setFilter(this.wineFilters);
  }
  wineSearched(term: string) {
    this.wineFilters.name = term;
    this.wineTable.dataSource.setFilter(this.wineFilters);
  }
  countrySelected(c: string) {
    this.wineryFilters.country = c;
    this.wineryTable.dataSource.setFilter(this.wineryFilters);

  }
  winerySearched(term: string) {
    this.wineryFilters.name = term;
    this.wineryTable.dataSource.setFilter(this.wineryFilters);
  }

  onWineAdd() {
    const ref = this.dialog.open(WineEditorComponent, {
      width: "75%",
      data: {}
    });
    ref.afterClosed().subscribe(data => {
      if(!data) return;
      this.wineService.insert(data)
      .subscribe(() => {
        this.wineTable.dataSource.getData();
        this.ui.showMessage("Wine added successfully");
      });
      console.log(data);
    })
  }

  onWineryAdd() {
    const ref = this.dialog.open(WineryEditorComponent, {
      width: "75%",
      data: {}
    });
    ref.afterClosed().subscribe(data => {
      if(!data) return;
      this.wineryService.insert(data)
      .subscribe(() => {
        this.wineTable.dataSource.getData();
        this.ui.showMessage("Winery added successfully");
      });
      console.log(data);
    })
  }
}
