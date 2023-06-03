import { AfterViewInit, Component, EventEmitter, Output, ViewChild } from '@angular/core';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort, Sort } from '@angular/material/sort';
import { MatTable } from '@angular/material/table';
import { WineService } from 'src/app/_services/wine.service';
import { SearchOptions, Wine, WineType } from 'src/app/_types';
import { WineTableDataSource } from './wine-table-datasource';

@Component({
  selector: 'app-wine-table',
  templateUrl: './wine-table.component.html',
  styleUrls: ['./wine-table.component.sass']
})
export class WineTableComponent implements AfterViewInit {
  @ViewChild(MatPaginator) paginator!: MatPaginator;
  @ViewChild(MatSort) sort!: MatSort;
  @ViewChild(MatTable) table!: MatTable<Wine>;
  dataSource: WineTableDataSource;

  @Output() onEdit = new EventEmitter<Wine>();
  @Output() onDelete = new EventEmitter<Wine>();

  /** Columns displayed in the table. Columns IDs can be added, removed, or reordered. */
  displayedColumns = ['name', 'type', 'year', 'price', 'winery', 'actions'];

  wineTypes = Object.values(WineType);

  filters: SearchOptions<Wine> = {};

  constructor(private wineService: WineService) {
    this.dataSource = new WineTableDataSource(this.wineService);
  }

  ngAfterViewInit(): void {
    this.table.dataSource = this.dataSource;
  }
  onSort(sort: Sort) {
    this.dataSource.setSort(sort);
  }

  wineTypeSelected(type?: WineType) {
    console.log(type);
    this.filters.type = type;
    this.dataSource.setFilter(this.filters);
  }
  editClicked(wine: Wine) {
    this.onEdit.emit(wine);
  }
  deleteClicked(wine: Wine) {
    this.onDelete.emit(wine);
  }
}
