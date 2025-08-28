// src/app/producto.service.ts
import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Producto } from '../interfaces/producto';

const headers = new HttpHeaders({ 'X-API-KEY': 'FTPGRV3344a' });

@Injectable({
  providedIn: 'root'
})
export class ProductoService {
  private apiUrl = 'https://padiyera.com/backend/public/api/productos'; //rutax

  //esta registrado en el providers del app.config.ts
  constructor(private http: HttpClient) { }

  getProductos(): Observable<Producto[]> {
    return this.http.get<Producto[]>(this.apiUrl, { headers });
  }

  actualizarProducto(id: number, producto: Producto) {
    return this.http.put<Producto>(`https://padiyera.com/backend/public/api/productos/${id}`, producto, { headers });//rutax
  }

  getProductoById(id: number): Observable<Producto> {
    return this.http.get<Producto>(`${this.apiUrl}/${id}`, { headers });
  }

}
