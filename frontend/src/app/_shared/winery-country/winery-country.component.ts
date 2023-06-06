import { Component, EventEmitter, Output } from '@angular/core';
import { MatSelectChange } from '@angular/material/select';
import { WineryService } from 'src/app/_services/winery.service';

@Component({
  selector: 'app-winery-country',
  templateUrl: './winery-country.component.html',
  styleUrls: ['./winery-country.component.sass']
})
export class WineryCountryComponent {
  @Output() onChange = new EventEmitter<string>();

  countries: string[] = [];

  selectChanged(event: MatSelectChange) {
    if(!event.value) this.onChange.emit(undefined);
    else this.onChange.emit(event.value);
  }
  constructor(
    private winery: WineryService
  ) {
    this.winery.getCountries()
      .subscribe(res => this.countries = res);
  }
}
