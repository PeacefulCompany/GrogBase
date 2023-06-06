import { Injectable } from '@angular/core';
import { MatSnackBar } from '@angular/material/snack-bar';

@Injectable({
  providedIn: 'root'
})
export class UiService {

  errorNoise = new Audio("../assets/error_noise.mp3");
  successNoise = new Audio("../assets/success_noise.mp3");
  constructor(
    private snackBar: MatSnackBar
  ) { }

  public showError(msg: string="Unknown") {
    this.errorNoise.play();
    this.snackBar.open("An error occured: " + msg, "Close", {
      panelClass: ["snack-error"],
      duration: 3000
    });
  }
  public showMessage(msg: string) {
    this.successNoise.play();
    this.snackBar.open(msg, "Close", {
      duration: 3000
    });
  }
}
