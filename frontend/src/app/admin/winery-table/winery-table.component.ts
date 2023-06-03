import { AfterViewInit, Component, ViewChild } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort, Sort } from '@angular/material/sort';
import { MatTable } from '@angular/material/table';
import { WineryService } from 'src/app/_services/winery.service';
import { WineryEditorComponent } from 'src/app/_shared/winery-editor/winery-editor.component';
import { Winery } from 'src/app/_types';
import { WineryTableDataSource } from './winery-table-datasource';

@Component({
  selector: 'app-winery-table',
  templateUrl: './winery-table.component.html',
  styleUrls: ['./winery-table.component.sass']
})
export class WineryTableComponent implements AfterViewInit {
  @ViewChild(MatPaginator) paginator!: MatPaginator;
  @ViewChild(MatSort) sort!: MatSort;
  @ViewChild(MatTable) table!: MatTable<Winery>;
  dataSource: WineryTableDataSource;

  /** Columns displayed in the table. Columns IDs can be added, removed, or reordered. */
  displayedColumns = ['name', 'established', 'location', 'region', 'country', 'website', 'actions'];

  constructor(
    private wineryService: WineryService,
    private dialogService: MatDialog
  ) {
    this.dataSource = new WineryTableDataSource(this.wineryService);
  }

  onSort(sort: Sort) {
    this.dataSource.setSort(sort);
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
      this.dataSource.updateWine(data);
    })
  }
  deleteWinery(winery: Winery) {
    this.wineryService.delete(winery);
    this.dataSource.removeWine(winery);
  }

  ngAfterViewInit(): void {
    this.table.dataSource = this.dataSource;
  }
}
