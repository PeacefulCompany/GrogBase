import { Injectable } from '@angular/core';
import { MatSnackBar } from '@angular/material/snack-bar';

@Injectable({
  providedIn: 'root'
})
export class UiService {

  constructor(
    private snackBar: MatSnackBar
  ) { }

  public showError(msg: string="Unknown") {
    this.snackBar.open("An error occured: " + msg, "Close", {
      panelClass: ["snack-error"],
      duration: 3000
    });
  }
  public showMessage(msg: string) {
    this.snackBar.open(msg, "Close", {
      duration: 3000
    });
  }
}
