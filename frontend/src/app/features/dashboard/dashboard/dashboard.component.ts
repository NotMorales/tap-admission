import { CommonModule } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { MatCardModule } from '@angular/material/card';
import { MatIconModule } from '@angular/material/icon';
import { ApiService } from '../../../core/services/api.service';

@Component({
  selector: 'app-dashboard',
  standalone: true,
  imports: [
    CommonModule,
    MatCardModule,
    MatIconModule
  ],
  templateUrl: './dashboard.component.html',
  styleUrl: './dashboard.component.scss'
})
export class DashboardComponent implements OnInit {
  totals = {
    products: 0,
    users: 0,
    profiles: 0,
    auditLogs: 0
  };

  constructor(private api: ApiService) {}

  ngOnInit(): void {
    this.loadTotals();
  }

  loadTotals(): void {
    this.api.get<any>('/products').subscribe(res => this.totals.products = res.pagination?.total ?? res.data?.length ?? 0);
    this.api.get<any>('/users').subscribe(res => this.totals.users = res.pagination?.total ?? res.data?.length ?? 0);
    this.api.get<any>('/profiles').subscribe(res => this.totals.profiles = res.pagination?.total ?? res.data?.length ?? 0);
    this.api.get<any>('/audit-logs').subscribe(res => this.totals.auditLogs = res.pagination?.total ?? res.data?.length ?? 0);
  }
}
