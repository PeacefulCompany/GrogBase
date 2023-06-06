import { Component, EventEmitter, Output } from '@angular/core';
import { MatSelectChange } from '@angular/material/select';
import {  WineType } from 'src/app/_types';
import { WineService } from 'src/app/_services/wine.service';

@Component({
  selector: 'app-wine-type',
  templateUrl: './wine-type.component.html',
  styleUrls: ['./wine-type.component.sass']
})
export class WineTypeComponent {
  @Output() onChange = new EventEmitter<WineType | undefined>();

  selected?: WineType;
  wineTypes = Object.values(WineType);

  selectChanged(event: MatSelectChange) {
    if(!event.value) this.onChange.emit(undefined);
    else this.onChange.emit(WineType.valueOf(event.value));
  }
  constructor(
    private wine: WineService
  ) {
    this.wine.getWineTypes()
    .subscribe(res => this.wineTypes = res);
  }
}
