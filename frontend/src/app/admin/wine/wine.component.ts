import { Component, EventEmitter, Input, Output } from '@angular/core';
import { Wine } from 'src/app/_types/wine.interface';

@Component({
  selector: 'app-wine',
  templateUrl: './wine.component.html',
  styleUrls: ['./wine.component.sass']
})
export class WineComponent {
  @Input() wine!: Wine;

  @Output() onEdit = new EventEmitter<Wine>();
  @Output() onDelete = new EventEmitter<Wine>();

  editClicked() {
    this.onEdit.emit(this.wine);
  }
  deleteClicked() {
    this.onDelete.emit(this.wine);
  }

  constructor() { }
}
