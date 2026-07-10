import { CommonModule } from '@angular/common';
import { Component, Inject, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { MAT_DIALOG_DATA, MatDialogModule, MatDialogRef } from '@angular/material/dialog';
import { MatButtonModule } from '@angular/material/button';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatSelectModule } from '@angular/material/select';

@Component({
  selector: 'app-user-form-dialog',
  standalone: true,
  imports: [
    CommonModule,
    ReactiveFormsModule,
    MatDialogModule,
    MatButtonModule,
    MatFormFieldModule,
    MatInputModule,
    MatSelectModule
  ],
  templateUrl: './user-form-dialog.component.html',
  styleUrl: './user-form-dialog.component.scss'
})
export class UserFormDialogComponent implements OnInit {
  form!: FormGroup;
  isEdit = false;
  selectedPhoto: File | null = null;

  constructor(
    private fb: FormBuilder,
    private dialogRef: MatDialogRef<UserFormDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
  ) {}

  ngOnInit(): void {
    this.isEdit = !!this.data?.user;

    this.form = this.fb.group({
      name: [this.data?.user?.name ?? '', [Validators.required]],
      email: [this.data?.user?.email ?? '', [Validators.required, Validators.email]],
      phone: [this.data?.user?.phone ?? ''],
      password: ['', this.isEdit ? [] : [Validators.required, Validators.minLength(8)]],
      profile_ids: [this.data?.user?.profile_ids ?? [], [Validators.required]],
      status: [this.data?.user?.status ?? 'ACTIVE', [Validators.required]],
    });
  }

  onPhotoSelected(event: Event): void {
    const input = event.target as HTMLInputElement;
    this.selectedPhoto = input.files?.[0] ?? null;
  }

  save(): void {
    if (this.form.invalid) {
      this.form.markAllAsTouched();
      return;
    }

    const payload = { ...this.form.value };

    if (this.isEdit && !payload.password) {
      delete payload.password;
    }

    this.dialogRef.close({
      user: payload,
      photo: this.selectedPhoto
    });
  }

  close(): void {
    this.dialogRef.close();
  }
}
