import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { MatFormFieldModule } from '@angular/material/form-field';
import { MatDialogModule } from '@angular/material/dialog';
import { MatInputModule } from '@angular/material/input';
import { MatGridListModule } from '@angular/material/grid-list';
import { MatButtonModule } from '@angular/material/button';

import { WineryEditorComponent } from './winery-editor/winery-editor.component';

@NgModule({
  declarations: [
    WineryEditorComponent
  ],
  imports: [
    CommonModule,
    FormsModule,

    MatFormFieldModule,
    MatDialogModule,
    MatInputModule,
    MatGridListModule,
    MatButtonModule
  ]
})
export class SharedModule { }
