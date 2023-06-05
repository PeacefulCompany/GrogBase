import { Component, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { Wine, WineReview } from 'src/app/_types';

@Component({
  selector: 'app-review-wine',
  templateUrl: './review-wine.component.html',
  styleUrls: ['./review-wine.component.sass']
})
export class ReviewWineComponent {
  rating: number = 1;
  review: string = "";
  drunk: boolean = false;

  constructor(
    @Inject(MAT_DIALOG_DATA) public data: Wine,
    private dialogRef: MatDialogRef<ReviewWineComponent>
  ) {

  }
  onCancel() {
    this.dialogRef.close();
  }
  onReview() {
    const data: WineReview = {
      points: this.rating,
      review: this.review,
      wine_id: this.data.wine_id,
      drunk: this.drunk
    }
    this.dialogRef.close(data);
  }

}
