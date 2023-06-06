import { Component, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { Winery, WineryReview } from 'src/app/_types';

@Component({
  selector: 'app-review-winery',
  templateUrl: './review-winery.component.html',
  styleUrls: ['./review-winery.component.sass']
})
export class ReviewWineryComponent {
  rating: number = 1;
  review: string = "";

  constructor(
    @Inject(MAT_DIALOG_DATA) public data: Winery,
    private dialogRef: MatDialogRef<ReviewWineryComponent>
  ) {

  }

  onCancel() {
    this.dialogRef.close();
  }
  onReview() {
    const data: WineryReview = {
      points: this.rating,
      review: this.review,
      winery_id: this.data.winery_id
    }
    this.dialogRef.close(data);
  }

}
