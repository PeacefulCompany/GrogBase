import { Component } from '@angular/core';
import { MatSelectChange } from '@angular/material/select';
import { WineryService } from '../_services/winery.service';
import { SearchOptions, SortBy, SortOrder, Winery } from '../_types';

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

  filters: SearchOptions<Winery> = {};
  sort?: SortBy<Winery>;

  constructor(
    private wineryService: WineryService
  ) {
    this.wineryService.getAll()
      .subscribe(res => this.wineries = res);
  }

  sortSelected(sort: MatSelectChange) {
    this.sort = sort.value;
    this.getData();
  }

  countrySelected(country: string) {
    this.filters.country = country;
    this.getData();
  }
  getData() {
    this.wineryService.getAll({
      search: this.filters,
      sortBy: this.sort
    })
    .subscribe(res => this.wineries = res);
  }
}
