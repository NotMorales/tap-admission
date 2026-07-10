import { CommonModule } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { MatCardModule } from '@angular/material/card';
import { ApiService } from '../../../core/services/api.service';
import { NotificationService } from '../../../core/services/notification.service';
import { DataTableColumn, DataTableComponent } from '../../../shared/data-table/data-table.component';

@Component({
  selector: 'app-sections-list',
  standalone: true,
  imports: [
    CommonModule,
    MatCardModule,
    DataTableComponent
  ],
  templateUrl: './sections-list.component.html',
  styleUrl: './sections-list.component.scss'
})
export class SectionsListComponent implements OnInit {
  sections: any[] = [];

  columns: DataTableColumn[] = [
    { key: 'code', label: 'Código' },
    { key: 'name', label: 'Nombre' },
    { key: 'route', label: 'Ruta' },
    { key: 'icon', label: 'Ícono' },
    { key: 'order', label: 'Orden' },
    { key: 'status', label: 'Estado', type: 'status' }
  ];

  constructor(
    private api: ApiService,
    private notification: NotificationService
  ) {}

  ngOnInit(): void {
    this.load();
  }

  load(): void {
    this.api.get<any>('/sections').subscribe({
      next: response => this.sections = response.data,
      error: () => this.notification.error('No se pudieron cargar las secciones.')
    });
  }

  view(row: any): void {
    alert(JSON.stringify(row, null, 2));
  }
}
