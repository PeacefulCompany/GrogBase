import { Component, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { Winery } from 'src/app/_types';


type WineryKey = keyof Winery;
const REQUIRED: WineryKey[] = [
  'name',
  'established',
  'country',
  'region',
  'location',
  'website',
  'description',
];

@Component({
  selector: 'app-winery-editor',
  templateUrl: './winery-editor.component.html',
  styleUrls: ['./winery-editor.component.sass'],
})
export class WineryEditorComponent {

  constructor(
    @Inject(MAT_DIALOG_DATA) public data: Winery,
    private dialogRef: MatDialogRef<WineryEditorComponent>
  ) { }

  onCancel() {
    this.dialogRef.close();
  }
  onSave() {
    const missing = REQUIRED.filter(elem => !Object.keys(this.data).includes(elem));

    if(missing.length > 0) {
      alert("You're missing some fields: " + JSON.stringify(missing));
      return;
    }

    this.dialogRef.close(this.data);
  }

}
