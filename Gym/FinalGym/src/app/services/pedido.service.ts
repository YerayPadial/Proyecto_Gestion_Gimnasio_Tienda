import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';

const headers = new HttpHeaders({ 'X-API-KEY': 'FTPGRV3344a' });

@Injectable({ providedIn: 'root' })
export class PedidoService {
  private apiUrl = 'https://gymfinaly.eu/backend/public/api/orders'; //rutax

  constructor(private http: HttpClient) { }

  crearPedido(data: any) {
    return this.http.post(this.apiUrl, data, { headers });
  }
}