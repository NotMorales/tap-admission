import { Routes } from '@angular/router';
import { authGuard } from './core/guards/auth.guard';
import { MainLayoutComponent } from './layout/main-layout/main-layout.component';
import { LoginComponent } from './features/auth/login/login.component';
import { ProductsListComponent } from './features/products/products-list/products-list.component';
import { UsersListComponent } from './features/users/users-list/users-list.component';
import { ProfilesListComponent } from './features/profiles/profiles-list/profiles-list.component';
import { AuditLogsListComponent } from './features/audit-logs/audit-logs-list/audit-logs-list.component';

export const routes: Routes = [
  {
    path: 'login',
    component: LoginComponent
  },
  {
    path: '',
    component: MainLayoutComponent,
    canActivate: [authGuard],
    children: [
      {
        path: '',
        redirectTo: 'products',
        pathMatch: 'full'
      },
      {
        path: 'products',
        component: ProductsListComponent
      },
      {
        path: 'users',
        component: UsersListComponent
      },
      {
        path: 'profiles',
        component: ProfilesListComponent
      },
      {
        path: 'audit-logs',
        component: AuditLogsListComponent
      }
    ]
  },
  {
    path: '**',
    redirectTo: ''
  }
];
