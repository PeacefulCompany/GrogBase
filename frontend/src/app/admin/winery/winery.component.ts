import { Component, EventEmitter, Input, Output } from '@angular/core';
import { Winery } from 'src/app/_types';

@Component({
  selector: 'app-winery',
  templateUrl: './winery.component.html',
  styleUrls: ['./winery.component.sass']
})
export class WineryComponent {
  @Input() winery!: Winery;

  @Output() onEdit = new EventEmitter<Winery>();
  @Output() onDelete = new EventEmitter<Winery>();

  editClicked() {
    this.onEdit.emit(this.winery);
  }
  deleteClicked() {
    this.onDelete.emit(this.winery);
  }
}
