import { CommonModule } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { MatCardModule } from '@angular/material/card';
import { MatButtonModule } from '@angular/material/button';
import { ApiService } from '../../../core/services/api.service';
import { AuthService } from '../../../core/services/auth.service';
import { DownloadService } from '../../../core/services/download.service';
import { NotificationService } from '../../../core/services/notification.service';
import { DataTableColumn, DataTableComponent } from '../../../shared/data-table/data-table.component';
import { MatDialog, MatDialogModule } from '@angular/material/dialog';
import { UserDetailDialogComponent } from '../user-detail-dialog/user-detail-dialog.component';
import { UserFormDialogComponent } from '../user-form-dialog/user-form-dialog.component';
import { ConfirmDialogComponent } from '../../../shared/confirm-dialog/confirm-dialog.component';

@Component({
  selector: 'app-users-list',
  standalone: true,
  imports: [CommonModule, MatCardModule, MatButtonModule, DataTableComponent, MatDialogModule],
  templateUrl: './users-list.component.html',
  styleUrl: './users-list.component.scss'
})
export class UsersListComponent implements OnInit {
  users: any[] = [];
  profiles: any[] = [];

  columns: DataTableColumn[] = [
    { key: 'code', label: 'Código' },
    { key: 'email', label: 'Usuario' },
    { key: 'name', label: 'Nombre' },
    { key: 'phone', label: 'Teléfono' },
    { key: 'created_at', label: 'Fecha creación' },
    { key: 'status', label: 'Estado', type: 'status' }
  ];

  constructor(
    private api: ApiService,
    public auth: AuthService,
    private downloadService: DownloadService,
    private notification: NotificationService,
    private dialog: MatDialog,
  ) {}

  ngOnInit(): void {
    this.load();
    this.loadProfiles();
  }

  load(): void {
    this.api.get<any>('/users').subscribe({
      next: response => this.users = response.data,
      error: () => this.notification.error('No se pudieron cargar los usuarios.')
    });
  }

  loadProfiles(): void {
    this.api.get<any>('/profiles').subscribe({
      next: response => {
        this.profiles = response.data;
      },
      error: () => {
        this.notification.error('No se pudieron cargar los perfiles.');
      }
    });
  }

  can(action: string): boolean {
    const section = this.auth.sections.find(item => item.route === '/users');
    return section?.permissions?.includes(action) ?? false;
  }

  exportPdf(): void {
    this.api.download('/users/export/pdf').subscribe({
      next: blob => this.downloadService.save(blob, 'users.pdf'),
      error: () => this.notification.error('No se pudo exportar PDF.')
    });
  }

  exportCsv(): void {
    this.api.download('/users/export/csv').subscribe({
      next: blob => this.downloadService.save(blob, 'users.csv'),
      error: () => this.notification.error('No se pudo exportar CSV.')
    });
  }

  view(row: any): void {
    this.api.get<any>(`/users/${row.id}`).subscribe({
      next: response => {
        this.dialog.open(UserDetailDialogComponent, {
          width: '560px',
          data: response.data
        });
      },
      error: () => this.notification.error('No se pudo cargar el detalle del usuario.')
    });
  }

  create(): void {
    const dialogRef = this.dialog.open(UserFormDialogComponent, {
      width: '560px',
      data: { profiles: this.profiles }
    });

    dialogRef.afterClosed().subscribe(result => {
      if (!result) return;

      this.api.post<any>('/users', result.user).subscribe({
        next: response => {
          const userId = response.data.id;

          if (result.photo) {
            this.uploadPhoto(userId, result.photo, 'Usuario creado correctamente.');
            return;
          }

          this.notification.success('Usuario creado correctamente.');
          this.load();
        },
        error: error => {
          console.error('CREATE USER ERROR:', error);
          this.notification.error(error?.error?.message || 'No se pudo crear el usuario.');
        }
      });
    });
  }

  edit(row: any): void {
    this.api.get<any>(`/users/${row.id}`).subscribe({
      next: response => {
        const dialogRef = this.dialog.open(UserFormDialogComponent, {
          width: '560px',
          data: {
            user: response.data,
            profiles: this.profiles
          }
        });

        dialogRef.afterClosed().subscribe(result => {
          if (!result) return;

          this.api.put<any>(`/users/${row.id}`, result.user).subscribe({
            next: () => {
              if (result.photo) {
                this.uploadPhoto(row.id, result.photo, 'Usuario actualizado correctamente.');
                return;
              }

              this.notification.success('Usuario actualizado correctamente.');
              this.load();
            },
            error: error => {
              console.error('UPDATE USER ERROR:', error);
              this.notification.error(error?.error?.message || 'No se pudo actualizar el usuario.');
            }
          });
        });
      },
      error: () => this.notification.error('No se pudo cargar el usuario.')
    });
  }

  delete(row: any): void {
    const dialogRef = this.dialog.open(ConfirmDialogComponent, {
      width: '420px',
      data: {
        title: 'Eliminar usuario',
        message: `¿Deseas eliminar el usuario "${row.name}"?`,
        confirmText: 'Eliminar',
        cancelText: 'Cancelar'
      }
    });

    dialogRef.afterClosed().subscribe(confirmed => {
      if (!confirmed) return;

      this.api.delete<any>(`/users/${row.id}`).subscribe({
        next: () => {
          this.notification.success('Usuario eliminado correctamente.');
          this.load();
        },
        error: () => this.notification.error('No se pudo eliminar el usuario.')
      });
    });
  }

  private uploadPhoto(userId: string, photo: File, successMessage: string): void {
    const formData = new FormData();
    formData.append('photo', photo);

    this.api.post<any>(`/users/${userId}/photo`, formData).subscribe({
      next: () => {
        this.notification.success(successMessage);
        this.load();
      },
      error: error => {
        console.error('UPLOAD PHOTO ERROR:', error);
        this.notification.error('El usuario se guardó, pero no se pudo subir la foto.');
        this.load();
      }
    });
  }
}
