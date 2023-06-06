import { Component, Input } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { UiService } from 'src/app/_services/ui.service';
import { WineService } from 'src/app/_services/wine.service';
import { Wine, WineReview } from 'src/app/_types';
import { ReviewWineComponent } from '../review-wine/review-wine.component';
import { SeeReviewsComponent } from '../see-reviews/see-reviews.component';
@Component({
  selector: 'app-wine',
  templateUrl: './wine.component.html',
  styleUrls: ['./wine.component.sass']
})
export class WineComponent{
  @Input() wine!: Wine;

  constructor(
    private dialog: MatDialog,
    private wineService: WineService,
    private ui: UiService
  ) { }
  reviewMe() {
    this.dialog.open(ReviewWineComponent, {
      data: this.wine
    }).afterClosed().subscribe(data => {
      if(!data) return;
      console.log(data);
      this.wineService.review(data)
        .subscribe(res => this.ui.showMessage(res));
    });
  }

  viewReviews() {
    this.wineService.getWineReviews(this.wine.wine_id)
    .subscribe((data:WineReview[]) => {
      this.dialog.open(SeeReviewsComponent, {
        data: {
          title: this.wine.name,
          reviews: data
        }
      });
    });
  }

}
