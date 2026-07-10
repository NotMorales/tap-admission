import { CommonModule } from '@angular/common';
import { Component, Inject } from '@angular/core';
import {
  MAT_DIALOG_DATA,
  MatDialogModule,
  MatDialogRef
} from '@angular/material/dialog';
import { MatButtonModule } from '@angular/material/button';
import { MatChipsModule } from '@angular/material/chips';
import { MatIconModule } from '@angular/material/icon';

@Component({
  selector: 'app-profile-detail-dialog',
  standalone: true,
  imports: [
    CommonModule,
    MatDialogModule,
    MatButtonModule,
    MatChipsModule,
    MatIconModule
  ],
  templateUrl: './profile-detail-dialog.component.html',
  styleUrl: './profile-detail-dialog.component.scss'
})
export class ProfileDetailDialogComponent {
  constructor(
    private dialogRef: MatDialogRef<ProfileDetailDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
  ) {}

  close(): void {
    this.dialogRef.close();
  }

  sectionName(sectionId: string): string {
    return this.data.sections
      ?.find((section: any) => section.id === sectionId)
      ?.name ?? sectionId;
  }
}
