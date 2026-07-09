import { CommonModule } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { MatButtonModule } from '@angular/material/button';
import { MatCardModule } from '@angular/material/card';
import { MatDialog, MatDialogModule } from '@angular/material/dialog';
import { ApiService } from '../../../core/services/api.service';
import { AuthService } from '../../../core/services/auth.service';
import { NotificationService } from '../../../core/services/notification.service';
import { DataTableColumn, DataTableComponent } from '../../../shared/data-table/data-table.component';
import { ProductFormDialogComponent } from '../product-form-dialog/product-form-dialog.component';
import { DownloadService } from '../../../core/services/download.service';

@Component({
  selector: 'app-products-list',
  standalone: true,
  imports: [
    CommonModule,
    MatCardModule,
    MatButtonModule,
    MatDialogModule,
    DataTableComponent
  ],
  templateUrl: './products-list.component.html',
  styleUrl: './products-list.component.scss'
})
export class ProductsListComponent implements OnInit {
  products: any[] = [];
  loading = false;

  columns: DataTableColumn[] = [
    { key: 'code', label: 'Código' },
    { key: 'name', label: 'Nombre' },
    { key: 'brand', label: 'Marca' },
    { key: 'price', label: 'Precio', type: 'money' },
    { key: 'created_at', label: 'Fecha creación' },
    { key: 'status', label: 'Estado', type: 'status' }
  ];

  constructor(
    private api: ApiService,
    public auth: AuthService,
    private dialog: MatDialog,
    private notification: NotificationService,
    private downloadService: DownloadService
  ) {}

  ngOnInit(): void {
    this.loadProducts();
  }

  loadProducts(): void {
    this.loading = true;

    this.api.get<any>('/products').subscribe({
      next: response => {
        this.products = response.data;
        this.loading = false;
      },
      error: () => {
        this.products = [];
        this.loading = false;
        this.notification.error('No se pudieron cargar los productos.');
      }
    });
  }

  can(action: string): boolean {
    const section = this.auth.sections.find(item => item.route === '/products');
    return section?.permissions?.includes(action) ?? false;
  }

  create(): void {
    const dialogRef = this.dialog.open(ProductFormDialogComponent, {
      width: '520px',
      data: {}
    });

    dialogRef.afterClosed().subscribe(form => {
      if (!form) return;

      this.api.post<any>('/products', form).subscribe({
        next: () => {
          this.notification.success('Producto creado correctamente.');
          this.loadProducts();
        },
        error: () => this.notification.error('No se pudo crear el producto.')
      });
    });
  }

  edit(row: any): void {
    const dialogRef = this.dialog.open(ProductFormDialogComponent, {
      width: '520px',
      data: { product: row }
    });

    dialogRef.afterClosed().subscribe(form => {
      if (!form) return;

      this.api.put<any>(`/products/${row.id}`, form).subscribe({
        next: () => {
          this.notification.success('Producto actualizado correctamente.');
          this.loadProducts();
        },
        error: () => this.notification.error('No se pudo actualizar el producto.')
      });
    });
  }

  delete(row: any): void {
    const ok = confirm(`¿Deseas eliminar el producto "${row.name}"?`);

    if (!ok) return;

    this.api.delete<any>(`/products/${row.id}`).subscribe({
      next: () => {
        this.notification.success('Producto eliminado correctamente.');
        this.loadProducts();
      },
      error: () => this.notification.error('No se pudo eliminar el producto.')
    });
  }

  view(row: any): void {
    alert(
      `Código: ${row.code}\nNombre: ${row.name}\nMarca: ${row.brand}\nPrecio: ${row.price}\nEstado: ${row.status}`
    );
  }

  exportPdf(): void {
    this.api.download('/products/export/pdf').subscribe({
      next: blob => this.downloadService.save(blob, 'products.pdf'),
      error: () => this.notification.error('No se pudo exportar PDF.')
    });
  }

  exportCsv(): void {
    this.api.download('/products/export/csv').subscribe({
      next: blob => this.downloadService.save(blob, 'products.csv'),
      error: () => this.notification.error('No se pudo exportar CSV.')
    });
  }
}
