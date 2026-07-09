import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { tap } from 'rxjs';
import { ApiService } from './api.service';
import { TokenService } from './token.service';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  user: any = null;
  sections: any[] = [];

  constructor(
    private api: ApiService,
    private tokenService: TokenService,
    private router: Router
  ) {}

  login(email: string, password: string) {
    return this.api.post<any>('/auth/login', { email, password }).pipe(
      tap(response => {
        this.tokenService.set(response.data.access_token);
        this.user = response.data.user;
        this.sections = response.data.sections;
      })
    );
  }

  me() {
    return this.api.get<any>('/auth/me').pipe(
      tap(response => {
        this.user = response.data.user;
        this.sections = response.data.sections;
      })
    );
  }

  logout(): void {
    this.api.post('/auth/logout', {}).subscribe({
      next: () => this.closeSession(),
      error: () => this.closeSession()
    });
  }

  closeSession(): void {
    this.tokenService.remove();
    this.user = null;
    this.sections = [];
    this.router.navigate(['/login']);
  }

  isAuthenticated(): boolean {
    return this.tokenService.exists();
  }
}
