import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class TokenService {
  private readonly key = 'tap_token';

  set(token: string): void {
    localStorage.setItem(this.key, token);
  }

  get(): string | null {
    return localStorage.getItem(this.key);
  }

  remove(): void {
    localStorage.removeItem(this.key);
  }

  exists(): boolean {
    return !!this.get();
  }
}
