import { Component, Input } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { WineService } from 'src/app/_services/wine.service';
import { Wine } from 'src/app/_types';
import { ReviewWineComponent } from '../review-wine/review-wine.component';

@Component({
  selector: 'app-wine',
  templateUrl: './wine.component.html',
  styleUrls: ['./wine.component.sass']
})
export class WineComponent{
  @Input() wine!: Wine;

  constructor(
    private dialog: MatDialog,
    private wineService: WineService
  ) { }
  reviewMe() {
    this.dialog.open(ReviewWineComponent, {
      data: this.wine
    }).afterClosed().subscribe(data => {
      if(!data) return;
      console.log(data);
      this.wineService.review(data).subscribe();
    });
  }
}
