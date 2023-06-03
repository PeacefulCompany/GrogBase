import { Component, OnInit } from '@angular/core';
import { Wine, Winery } from '../_types';
import { WineService } from '../_services/wine.service';


@Component({
  selector: 'app-wines',
  templateUrl: './wines.component.html',
  styleUrls: ['./wines.component.sass']
})
export class WinePage implements OnInit {
  WineList: Wine[] = [];
  constructor( private wineService: WineService,) {
    this.wineService.getAll()
      .subscribe(res => this.WineList = res);
  }

  ngOnInit(): void {
  }

}
