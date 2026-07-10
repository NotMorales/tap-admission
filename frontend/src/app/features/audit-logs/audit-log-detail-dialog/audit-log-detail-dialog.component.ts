import { CommonModule } from '@angular/common';
import { Component, Inject } from '@angular/core';
import {
  MAT_DIALOG_DATA,
  MatDialogModule,
  MatDialogRef
} from '@angular/material/dialog';
import { MatButtonModule } from '@angular/material/button';

@Component({
  selector: 'app-audit-log-detail-dialog',
  standalone: true,
  imports: [
    CommonModule,
    MatDialogModule,
    MatButtonModule
  ],
  templateUrl: './audit-log-detail-dialog.component.html',
  styleUrl: './audit-log-detail-dialog.component.scss'
})
export class AuditLogDetailDialogComponent {
  constructor(
    private dialogRef: MatDialogRef<AuditLogDetailDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
  ) {
    console.log('AUDIT DETAIL:', data);
  }

  close(): void {
    this.dialogRef.close();
  }

  hasContent(value: unknown): boolean {
    if (value === null || value === undefined) {
      return false;
    }

    if (Array.isArray(value)) {
      return value.length > 0;
    }

    if (typeof value === 'object') {
      return Object.keys(value as object).length > 0;
    }

    return String(value).trim().length > 0;
  }
}
