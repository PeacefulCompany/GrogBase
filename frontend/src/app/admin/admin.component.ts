import { AfterViewInit, Component, ElementRef, ViewChild } from '@angular/core';
import { debounceTime, distinctUntilChanged, filter, fromEvent, map, of, tap } from 'rxjs';
import { WineryService } from '../_services/winery.service';
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
    private wineryService: WineryService
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
    alert("Add wine");
  }

  onWineryAdd() {
    alert("Add winery");
  }
}
