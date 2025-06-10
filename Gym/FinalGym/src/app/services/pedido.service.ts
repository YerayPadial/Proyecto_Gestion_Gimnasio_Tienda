import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';

const headers = new HttpHeaders({ 'X-API-KEY': 'FTPGRV3344a' });

@Injectable({ providedIn: 'root' })
export class PedidoService {
  private apiUrl = 'https://ieslamarisma.net/proyectos/2025/yeraipadial/gymfinal/public/api/orders'; //rutax

  constructor(private http: HttpClient) { }

  crearPedido(data: any) {
    return this.http.post(this.apiUrl, data, { headers });
  }
}