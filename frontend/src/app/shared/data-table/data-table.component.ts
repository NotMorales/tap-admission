import { CommonModule } from '@angular/common';
import { Component, EventEmitter, Input, Output } from '@angular/core';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { MatTableModule } from '@angular/material/table';

export interface DataTableColumn {
  key: string;
  label: string;
  type?: 'text' | 'money' | 'status' | 'date';
}

@Component({
  selector: 'app-data-table',
  standalone: true,
  imports: [
    CommonModule,
    MatTableModule,
    MatButtonModule,
    MatIconModule
  ],
  templateUrl: './data-table.component.html',
  styleUrl: './data-table.component.scss'
})
export class DataTableComponent {
  @Input() columns: DataTableColumn[] = [];
  @Input() rows: any[] = [];
  @Input() canView = true;
  @Input() canEdit = false;
  @Input() canDelete = false;

  @Output() view = new EventEmitter<any>();
  @Output() edit = new EventEmitter<any>();
  @Output() delete = new EventEmitter<any>();

  get displayedColumns(): string[] {
    return [...this.columns.map(column => column.key), 'actions'];
  }
}
