import { Component, OnInit } from '@angular/core';
import { WineService } from '../_services/wine.service';
import { SortBy, SortOrder,Wine} from '../_types';

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
export class WinePage implements OnInit {
  WineList: Wine[] = [];
  sortOptions = SORT_OPTIONS;
  constructor( private wineService: WineService,) {
    this.wineService.getAll()
      .subscribe(res => this.WineList = res);
  }

  ngOnInit(): void {
  }

}
