import { Component, Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { WineReview} from 'src/app/_types';

interface DialogData {
  title: string;
  reviews: WineReview[];
}

@Component({
  selector: 'app-see-reviews',
  templateUrl: './see-reviews.component.html',
  styleUrls: ['./see-reviews.component.sass']
})
export class SeeReviewsComponent{

  constructor(
    public dialogRef: MatDialogRef<SeeReviewsComponent>,
    @Inject(MAT_DIALOG_DATA) public data: DialogData
    ){}

    closeDialog(): void {
      this.dialogRef.close();
    }
}
