import { Component, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { Winery } from 'src/app/_types';

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
    this.dialogRef.close(this.data);
  }

}
