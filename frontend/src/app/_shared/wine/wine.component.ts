import { Component, Input } from '@angular/core';
import { Wine } from 'src/app/_types';

@Component({
  selector: 'app-wine',   
  templateUrl: './wine.component.html',
  styleUrls: ['./wine.component.sass']
})
export class WineComponent{
  @Input() wine!: Wine;

  constructor() { }
}
