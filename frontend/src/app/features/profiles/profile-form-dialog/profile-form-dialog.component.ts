import { CommonModule } from '@angular/common';
import { Component, Inject, OnInit } from '@angular/core';
import {
  FormArray,
  FormBuilder,
  FormGroup,
  ReactiveFormsModule,
  Validators
} from '@angular/forms';
import {
  MAT_DIALOG_DATA,
  MatDialogModule,
  MatDialogRef
} from '@angular/material/dialog';
import { MatButtonModule } from '@angular/material/button';
import { MatCheckboxModule } from '@angular/material/checkbox';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatSelectModule } from '@angular/material/select';

@Component({
  selector: 'app-profile-form-dialog',
  standalone: true,
  imports: [
    CommonModule,
    ReactiveFormsModule,
    MatDialogModule,
    MatButtonModule,
    MatCheckboxModule,
    MatFormFieldModule,
    MatInputModule,
    MatSelectModule
  ],
  templateUrl: './profile-form-dialog.component.html',
  styleUrl: './profile-form-dialog.component.scss'
})
export class ProfileFormDialogComponent implements OnInit {
  form!: FormGroup;
  isEdit = false;

  readonly actions = [
    'VIEW',
    'CREATE',
    'UPDATE',
    'DELETE',
    'EXPORT'
  ];

  constructor(
    private fb: FormBuilder,
    private dialogRef: MatDialogRef<ProfileFormDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: {
      profile?: any;
      sections: any[];
    }
  ) {}

  ngOnInit(): void {
    this.isEdit = !!this.data?.profile;

    this.form = this.fb.group({
      name: [
        this.data?.profile?.name ?? '',
        [Validators.required, Validators.maxLength(100)]
      ],
      status: [
        this.data?.profile?.status ?? 'ACTIVE',
        [Validators.required]
      ],
      permissions: this.fb.array([])
    });

    this.buildPermissions();
  }

  get permissions(): FormArray {
    return this.form.get('permissions') as FormArray;
  }

  private buildPermissions(): void {
    const currentPermissions = this.data?.profile?.permissions ?? [];

    this.data.sections.forEach(section => {
      const existing = currentPermissions.find(
        (permission: any) => permission.section_id === section.id
      );

      this.permissions.push(
        this.fb.group({
          section_id: [section.id],
          section_name: [section.name],
          actions: this.fb.group({
            VIEW: [existing?.actions?.includes('VIEW') ?? false],
            CREATE: [existing?.actions?.includes('CREATE') ?? false],
            UPDATE: [existing?.actions?.includes('UPDATE') ?? false],
            DELETE: [existing?.actions?.includes('DELETE') ?? false],
            EXPORT: [existing?.actions?.includes('EXPORT') ?? false]
          })
        })
      );
    });
  }

  save(): void {
    if (this.form.invalid) {
      this.form.markAllAsTouched();
      return;
    }

    const value = this.form.getRawValue();

    const permissions = value.permissions
      .map((permission: any) => ({
        section_id: permission.section_id,
        actions: Object.entries(permission.actions)
          .filter(([, enabled]) => enabled)
          .map(([action]) => action)
      }))
      .filter((permission: any) => permission.actions.length > 0);

    this.dialogRef.close({
      name: value.name,
      status: value.status,
      permissions
    });
  }

  close(): void {
    this.dialogRef.close();
  }
}
