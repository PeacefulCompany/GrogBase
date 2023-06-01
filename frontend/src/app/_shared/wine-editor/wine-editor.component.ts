import { Component, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { Wine, WineType } from 'src/app/_types';

@Component({
  selector: 'app-wine-editor',
  templateUrl: './wine-editor.component.html',
  styleUrls: ['./wine-editor.component.sass'],
})
export class WineEditorComponent {
  wineTypes = Object.values(WineType);

  constructor(
    @Inject(MAT_DIALOG_DATA) public data: Wine,
    private dialogRef: MatDialogRef<WineEditorComponent>
  ) { }

  onCancel() {
    this.dialogRef.close();
  }
  onSave() {
    this.dialogRef.close(this.data);
  }

}
