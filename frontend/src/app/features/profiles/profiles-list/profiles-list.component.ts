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
  selector: 'app-profiles-list',
  standalone: true,
  imports: [CommonModule, MatCardModule, MatButtonModule, DataTableComponent],
  templateUrl: './profiles-list.component.html',
  styleUrl: './profiles-list.component.scss'
})
export class ProfilesListComponent implements OnInit {
  profiles: any[] = [];

  columns: DataTableColumn[] = [
    { key: 'code', label: 'Código' },
    { key: 'name', label: 'Nombre' },
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
    this.api.get<any>('/profiles').subscribe({
      next: response => this.profiles = response.data,
      error: () => this.notification.error('No se pudieron cargar los perfiles.')
    });
  }

  can(action: string): boolean {
    const section = this.auth.sections.find(item => item.route === '/profiles');
    return section?.permissions?.includes(action) ?? false;
  }

  exportPdf(): void {
    this.api.download('/profiles/export/pdf').subscribe({
      next: blob => this.downloadService.save(blob, 'profiles.pdf'),
      error: () => this.notification.error('No se pudo exportar PDF.')
    });
  }

  exportCsv(): void {
    this.api.download('/profiles/export/csv').subscribe({
      next: blob => this.downloadService.save(blob, 'profiles.csv'),
      error: () => this.notification.error('No se pudo exportar CSV.')
    });
  }

  view(row: any): void {
    alert(JSON.stringify(row, null, 2));
  }
}
