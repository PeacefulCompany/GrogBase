import { Component, Input } from '@angular/core';
import { Winery } from 'src/app/_types';

@Component({
  selector: 'app-winery',
  templateUrl: './winery.component.html',
  styleUrls: ['./winery.component.sass']
})
export class WineryComponent {
  @Input() winery!: Winery;

  constructor() { }
}
