import { CommonModule } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { MatCardModule } from '@angular/material/card';
import { MatButtonModule } from '@angular/material/button';
import { ApiService } from '../../../core/services/api.service';
import { AuthService } from '../../../core/services/auth.service';
import { DownloadService } from '../../../core/services/download.service';
import { NotificationService } from '../../../core/services/notification.service';
import { DataTableColumn, DataTableComponent } from '../../../shared/data-table/data-table.component';

@Component({
  selector: 'app-users-list',
  standalone: true,
  imports: [CommonModule, MatCardModule, MatButtonModule, DataTableComponent],
  templateUrl: './users-list.component.html',
  styleUrl: './users-list.component.scss'
})
export class UsersListComponent implements OnInit {
  users: any[] = [];

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
    private notification: NotificationService
  ) {}

  ngOnInit(): void {
    this.load();
  }

  load(): void {
    this.api.get<any>('/users').subscribe({
      next: response => this.users = response.data,
      error: () => this.notification.error('No se pudieron cargar los usuarios.')
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
    alert(JSON.stringify(row, null, 2));
  }
}
