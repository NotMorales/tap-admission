import { CommonModule } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { MatButtonModule } from '@angular/material/button';
import { MatCardModule } from '@angular/material/card';
import { MatDialog, MatDialogModule } from '@angular/material/dialog';

import { ApiService } from '../../../core/services/api.service';
import { AuthService } from '../../../core/services/auth.service';
import { DownloadService } from '../../../core/services/download.service';
import { NotificationService } from '../../../core/services/notification.service';
import {
  DataTableColumn,
  DataTableComponent
} from '../../../shared/data-table/data-table.component';
import { ConfirmDialogComponent } from '../../../shared/confirm-dialog/confirm-dialog.component';
import { ProfileFormDialogComponent } from '../profile-form-dialog/profile-form-dialog.component';
import { ProfileDetailDialogComponent } from '../profile-detail-dialog/profile-detail-dialog.component';

@Component({
  selector: 'app-profiles-list',
  standalone: true,
  imports: [
    CommonModule,
    MatCardModule,
    MatButtonModule,
    MatDialogModule,
    DataTableComponent
  ],
  templateUrl: './profiles-list.component.html',
  styleUrl: './profiles-list.component.scss'
})
export class ProfilesListComponent implements OnInit {
  profiles: any[] = [];
  sections: any[] = [];

  columns: DataTableColumn[] = [
    { key: 'code', label: 'Código' },
    { key: 'name', label: 'Nombre' },
    { key: 'created_at', label: 'Fecha creación' },
    { key: 'status', label: 'Estado', type: 'status' }
  ];

  constructor(
    private api: ApiService,
    public auth: AuthService,
    private dialog: MatDialog,
    private downloadService: DownloadService,
    private notification: NotificationService
  ) {}

  ngOnInit(): void {
    this.load();
    this.loadSections();
  }

  load(): void {
    this.api.get<any>('/profiles').subscribe({
      next: response => {
        this.profiles = response.data;
      },
      error: () => {
        this.notification.error('No se pudieron cargar los perfiles.');
      }
    });
  }

  loadSections(): void {
    this.api.get<any>('/sections', { per_page: 100 }).subscribe({
      next: response => {
        this.sections = response.data;
      },
      error: () => {
        this.notification.error('No se pudieron cargar las secciones.');
      }
    });
  }

  can(action: string): boolean {
    const section = this.auth.sections.find(
      item => item.route === '/profiles'
    );

    return section?.permissions?.includes(action) ?? false;
  }

  create(): void {
    const dialogRef = this.dialog.open(ProfileFormDialogComponent, {
      width: '900px',
      maxWidth: '95vw',
      data: {
        sections: this.sections
      }
    });

    dialogRef.afterClosed().subscribe(payload => {
      if (!payload) {
        return;
      }

      this.api.post<any>('/profiles', payload).subscribe({
        next: () => {
          this.notification.success('Perfil creado correctamente.');
          this.load();
        },
        error: error => {
          this.notification.error(
            error?.error?.message || 'No se pudo crear el perfil.'
          );
        }
      });
    });
  }

  view(row: any): void {
    this.api.get<any>(`/profiles/${row.id}`).subscribe({
      next: response => {
        this.dialog.open(ProfileDetailDialogComponent, {
          width: '720px',
          data: {
            profile: response.data,
            sections: this.sections
          }
        });
      },
      error: () => {
        this.notification.error('No se pudo cargar el perfil.');
      }
    });
  }

  edit(row: any): void {
    this.api.get<any>(`/profiles/${row.id}`).subscribe({
      next: response => {
        const dialogRef = this.dialog.open(ProfileFormDialogComponent, {
          width: '900px',
          maxWidth: '95vw',
          data: {
            profile: response.data,
            sections: this.sections
          }
        });

        dialogRef.afterClosed().subscribe(payload => {
          if (!payload) {
            return;
          }

          this.api.put<any>(`/profiles/${row.id}`, payload).subscribe({
            next: () => {
              this.notification.success(
                'Perfil actualizado correctamente.'
              );
              this.load();
            },
            error: error => {
              this.notification.error(
                error?.error?.message ||
                'No se pudo actualizar el perfil.'
              );
            }
          });
        });
      },
      error: () => {
        this.notification.error('No se pudo cargar el perfil.');
      }
    });
  }

  delete(row: any): void {
    const dialogRef = this.dialog.open(ConfirmDialogComponent, {
      width: '420px',
      data: {
        title: 'Eliminar perfil',
        message: `¿Deseas eliminar el perfil "${row.name}"?`,
        confirmText: 'Eliminar',
        cancelText: 'Cancelar'
      }
    });

    dialogRef.afterClosed().subscribe(confirmed => {
      if (!confirmed) {
        return;
      }

      this.api.delete<any>(`/profiles/${row.id}`).subscribe({
        next: () => {
          this.notification.success('Perfil eliminado correctamente.');
          this.load();
        },
        error: error => {
          this.notification.error(
            error?.error?.message || 'No se pudo eliminar el perfil.'
          );
        }
      });
    });
  }

  exportPdf(): void {
    this.api.download('/profiles/export/pdf').subscribe({
      next: blob => {
        this.downloadService.save(blob, 'profiles.pdf');
      },
      error: () => {
        this.notification.error('No se pudo exportar PDF.');
      }
    });
  }

  exportCsv(): void {
    this.api.download('/profiles/export/csv').subscribe({
      next: blob => {
        this.downloadService.save(blob, 'profiles.csv');
      },
      error: () => {
        this.notification.error('No se pudo exportar CSV.');
      }
    });
  }
}
