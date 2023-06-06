import { AfterViewInit, Component, EventEmitter, Output, ViewChild } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort, Sort } from '@angular/material/sort';
import { MatTable } from '@angular/material/table';
import { WineService } from 'src/app/_services/wine.service';
import { WineEditorComponent } from 'src/app/_shared/wine-editor/wine-editor.component';
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

  /** Columns displayed in the table. Columns IDs can be added, removed, or reordered. */
  displayedColumns = ['name', 'type', 'year', 'price', 'winery', 'actions'];

  wineTypes = Object.values(WineType);

  filters: SearchOptions<Wine> = {};

  constructor(
    private wineService: WineService,
    private dialogService: MatDialog
  ) {
    this.dataSource = new WineTableDataSource(this.wineService);
  }

  ngAfterViewInit(): void {
    this.table.dataSource = this.dataSource;
  }
  onSort(sort: Sort) {
    this.dataSource.setSort(sort);
  }

  deleteWine(wine: Wine) {
    this.wineService.delete(wine).subscribe();
    this.dataSource.removeWine(wine);
  }

  editWine(wine: Wine) {
    const ref = this.dialogService.open(WineEditorComponent, {
      data: wine,
      width: "75%",
      minHeight: "75%"
    });
    ref.afterClosed().subscribe(data => {
      if(!data) return;
      this.wineService.update(data).subscribe();
      this.dataSource.updateWine(data);
    })
  }
}