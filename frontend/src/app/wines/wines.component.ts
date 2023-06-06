import { Component, OnInit } from '@angular/core';
import { MatSelectChange } from '@angular/material/select';
import { WineService } from '../_services/wine.service';
import { SearchOptions, SortBy, SortOrder,Wine} from '../_types';
import { WineType } from '../_types';

const SORT_OPTIONS: { label: string, sortBy: SortBy<Wine> }[] = [
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
  selector: 'app-wines',
  templateUrl: './wines.component.html',
  styleUrls: ['./wines.component.sass']
})
export class WinePage{
  WineList: Wine[] = [];
  sortOptions = SORT_OPTIONS;

  filters: SearchOptions<Wine> = {};
  sort?: SortBy<Wine>;

  constructor( private wineService: WineService,) {
    this.wineService.getAll()
      .subscribe(res => this.WineList = res);
  }

  sortSelected(sort: MatSelectChange) {
    this.sort = sort.value;
    this.getData(); 
  }
  TypeSelected(WineType: WineType | undefined) {
    this.filters.type = WineType;
    this.getData();
  }
  getData() {
    this.wineService.getAll({
      search: this.filters,
      sortBy: this.sort 
    })
    .subscribe(res => this.WineList = res);
  }
}
