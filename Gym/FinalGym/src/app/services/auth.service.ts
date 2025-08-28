import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Cliente } from '../interfaces/cliente';
import { Observable } from 'rxjs';

const headers = new HttpHeaders({ 'X-API-KEY': 'FTPGRV3344a' });

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private apiUrl = 'https://padiyera.com/backend/public/api/verificar-usuario';
  //rutax

  constructor(private http: HttpClient) { }

  verificarUsuario(identificador: string): Observable<{ rol: string; cliente?: Cliente }> {
    return this.http.post<{ rol: string; cliente?: Cliente }>(this.apiUrl, { identificador }, { headers });
  }

  enviarCodigo(dni: string): Observable<any> {
    return this.http.post('https://padiyera.com/backend/public/api/enviar-codigo', { dni }, { headers });//rutax
  }

  verificarCodigo(dni: string, codigo: string): Observable<{ valid: boolean }> {
    return this.http.post<{ valid: boolean }>('https://padiyera.com/backend/public/api/verificar-codigo', { dni, codigo }, { headers });//rutax
  }
}
