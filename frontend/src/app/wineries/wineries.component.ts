import { Component } from '@angular/core';
import { WineryService } from '../_services/winery.service';
import { SortBy, SortOrder, Winery } from '../_types';

const SORT_OPTIONS: { label: string, sortBy: SortBy<Winery> }[] = [
  {
    label: "Alphabetical (A-Z)",
    sortBy: {
      key: "name",
      order: SortOrder.Ascending
    }
  },
  {
    label: "Alphabetical (Z-A)",
    sortBy: {
      key: "name",
      order: SortOrder.Descending
    }
  }
];

@Component({
  selector: 'app-wineries',
  templateUrl: './wineries.component.html',
  styleUrls: ['./wineries.component.sass']
})
export class WineriesPage {
  wineries: Winery[] = [];
  sortOptions = SORT_OPTIONS;

  constructor(
    private wineryService: WineryService
  ) {
    this.wineryService.getAll()
      .subscribe(res => this.wineries = res);
  }
}
