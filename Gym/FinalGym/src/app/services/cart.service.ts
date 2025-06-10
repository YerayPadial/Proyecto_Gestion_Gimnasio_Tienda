import { Injectable } from '@angular/core';
import { Producto } from '../interfaces/producto';

@Injectable({
  providedIn: 'root'
})
export class CartService {
  private carrito: { producto: Producto; cantidad: number }[] = [];

  constructor() {
    this.cargarCarrito();
  }

  private guardarCarrito() {
    localStorage.setItem('carrito', JSON.stringify(this.carrito));
  }

  private cargarCarrito() {
    const datos = localStorage.getItem('carrito');
    if (datos) {
      this.carrito = JSON.parse(datos);
    }
  }

  getCarrito() {
    return this.carrito;
  }

  agregarAlCarrito(producto: Producto, cantidad: number = 1) {
    const index = this.carrito.findIndex(item => item.producto.id === producto.id);

    if (index !== -1) {
      const nuevaCantidad = this.carrito[index].cantidad + cantidad;
      this.carrito[index].cantidad = Math.min(nuevaCantidad, producto.existencias);
    } else {
      this.carrito.push({ producto: { ...producto }, cantidad });
    }

    this.guardarCarrito();
  }

  limpiarCarrito() {
    this.carrito = [];
    this.guardarCarrito();
  }

  eliminarItem(index: number) {
    this.carrito.splice(index, 1);
    this.guardarCarrito();
  }

  aumentarCantidad(index: number) {
    const item = this.carrito[index];
    if (item.cantidad < item.producto.existencias) {
      item.cantidad++;
      this.guardarCarrito();
    }
  }

  disminuirCantidad(index: number) {
    const item = this.carrito[index];
    if (item.cantidad > 1) {
      item.cantidad--;
    } else {
      this.eliminarItem(index);
      return;
    }
    this.guardarCarrito();
  }
}
