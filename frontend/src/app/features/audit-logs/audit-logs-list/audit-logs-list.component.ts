import { CommonModule } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { MatCardModule } from '@angular/material/card';
import { ApiService } from '../../../core/services/api.service';
import { NotificationService } from '../../../core/services/notification.service';
import { DataTableColumn, DataTableComponent } from '../../../shared/data-table/data-table.component';

@Component({
  selector: 'app-audit-logs-list',
  standalone: true,
  imports: [CommonModule, MatCardModule, DataTableComponent],
  templateUrl: './audit-logs-list.component.html',
  styleUrl: './audit-logs-list.component.scss'
})
export class AuditLogsListComponent implements OnInit {
  logs: any[] = [];

  columns: DataTableColumn[] = [
    { key: 'module', label: 'Módulo' },
    { key: 'action', label: 'Acción' },
    { key: 'record_code', label: 'Registro' },
    { key: 'created_at', label: 'Fecha' }
  ];

  constructor(
    private api: ApiService,
    private notification: NotificationService
  ) {}

  ngOnInit(): void {
    this.load();
  }

  load(): void {
    this.api.get<any>('/audit-logs').subscribe({
      next: response => this.logs = response.data,
      error: () => this.notification.error('No se pudo cargar la bitácora.')
    });
  }

  view(row: any): void {
    alert(JSON.stringify(row, null, 2));
  }
}
