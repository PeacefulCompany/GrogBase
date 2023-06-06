import { Component, Inject} from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { WineryReview} from 'src/app/_types';

interface DialogData {
  title: string;
  reviews: WineryReview[];
}
@Component({
  selector: 'app-see-winery-reviews',
  templateUrl: './see-winery-reviews.component.html',
  styleUrls: ['./see-winery-reviews.component.sass']
})
export class SeeWineryReviewsComponent {
  constructor(
    public dialogRef: MatDialogRef<SeeWineryReviewsComponent>,
    @Inject(MAT_DIALOG_DATA) public data: DialogData
    ){}

    closeDialog(): void {
      this.dialogRef.close();
    }
}
