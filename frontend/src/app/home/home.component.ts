import { Component } from '@angular/core';
import { WineService } from '../_services/wine.service';
import { WineryService } from '../_services/winery.service';
import { Wine, Winery } from '../_types';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.sass']
})
export class HomeComponent {
  TopWine: Wine[] = [];
  Localwiener: Winery[] = [];

  constructor(
    private wineService: WineService,
    private wineryService: WineryService
  ) {
    this.wineService.getTopWines()
      .subscribe(res => this.TopWine = res);
    this.wineryService.getTopWineries()
      .subscribe(res => this.Localwiener = res);
  }
}
