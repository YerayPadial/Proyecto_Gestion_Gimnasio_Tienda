import { Component, OnInit, DoCheck } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Producto } from '../interfaces/producto';
import { ProductoService } from '../services/producto.service';
import { Router } from '@angular/router';
import { CartService } from '../services/cart.service';
import { MatBadgeModule } from '@angular/material/badge';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-articulos',
  standalone: true,
  imports: [CommonModule, FormsModule, MatBadgeModule],
  templateUrl: './articulos.component.html',
  styleUrls: ['./articulos.component.css']
})
export class ArticulosComponent implements OnInit, DoCheck {
  productos: Producto[] = [];
  filtro: string = '';
  mostrarCarrito: boolean = false;
  fadeOutClass: string = '';
  cantidadSeleccionada: { [productoId: number]: number } = {};
  categoriasUnicas: string[] = [];
  categoriaSeleccionada: string = '';

  constructor(
    private productoService: ProductoService,
    private router: Router,
    public cartService: CartService
  ) { }

  ngOnInit(): void {
    this.productoService.getProductos().subscribe(data => {
      this.productos = data;
      const tipos = data.map(p => p.categoria?.tipo).filter(Boolean);
      this.categoriasUnicas = [...new Set(tipos)];
    });
  }

  ngDoCheck(): void {
    // Angular lifecycle hooks para observar cambios en el carrito
    if (this.mostrarCarrito && this.carrito.length === 0) {
      this.mostrarCarrito = false;
      Swal.fire({
        icon: 'info',
        title: 'Carrito vacío',
        text: 'El carrito se ha quedado sin artículos.',
        timer: 1500,
        showConfirmButton: false
      });
    }
  }

  get carrito() {
    return this.cartService.getCarrito();
  }

  get totalSinIVA(): number {
    return this.carrito.reduce((total, item) => {
      const precio = Number(item.producto.precio) || 0;
      const cantidad = Number(item.cantidad) || 0;
      return total + precio * cantidad;
    }, 0);
  }

  get totalConIVA(): number {
    return this.totalSinIVA * 1.21;
  }

  obtenerCantidadTotal(): number {
    return this.cartService.getCarrito().reduce((total, item) => total + item.cantidad, 0);
  }

  agregarAlCarrito(producto: Producto, cantidad: number = 1) {
    this.cartService.agregarAlCarrito(producto, cantidad);

    if (!this.mostrarCarrito) {
      Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: `${producto.nombre} añadido al carrito`,
        showConfirmButton: true,
        confirmButtonText: 'Ver carrito',
        timer: 3000,
        timerProgressBar: true
      }).then((result) => {
        if (result.isConfirmed) {
          this.toggleCarrito();
        }
      });
    } else {
      Swal.fire({
        toast: false,
        position: 'center',
        icon: 'success',
        title: `${producto.nombre} añadido al carrito`,
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true
      });
    }
  }

  get productosFiltrados(): Producto[] {
    const filtroLower = this.filtro.toLowerCase();

    return this.productos.filter(producto => {
      const coincideFiltro = producto.nombre.toLowerCase().includes(filtroLower) ||
        producto.descripcion?.toLowerCase().includes(filtroLower) ||
        producto.categoria?.tipo.toLowerCase().includes(filtroLower) ||
        producto.precio.toString().includes(filtroLower);

      const coincideCategoria = !this.categoriaSeleccionada || producto.categoria?.tipo === this.categoriaSeleccionada;

      return coincideFiltro && coincideCategoria;
    });
  }
  toggleCarrito() {
    if (!this.mostrarCarrito) {
      this.fadeOutClass = 'fade-out';
      setTimeout(() => {
        this.mostrarCarrito = true;
        this.fadeOutClass = '';
      }, 300);
    } else {
      this.mostrarCarrito = false;
    }
  }
  validarCantidad(producto: Producto) {
    let cantidad = this.cantidadSeleccionada[producto.id];

    if (cantidad > producto.existencias) {
      Swal.fire({
        icon: 'error',
        title: 'Sin existencias',
        text: 'No hay suficientes existencias.',
        timer: 1500,
        showConfirmButton: false
      }).then(() => {
        this.cantidadSeleccionada[producto.id] = producto.existencias;
      });
      return;
    }

    if (cantidad < 1 || !cantidad) {
      Swal.fire({
        icon: 'warning',
        title: 'Cantidad inválida',
        text: 'La cantidad debe ser mayor a 0',
        timer: 1500,
        showConfirmButton: false
      }).then(() => {
        this.cantidadSeleccionada[producto.id] = 1;
      });
      return;
    }
  }


  cleanShoppingCart() {
    Swal.fire({
      title: '¿Estás seguro?',
      text: '¡Vas a vaciar el carrito!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Sí, vaciar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        this.cartService.limpiarCarrito();
        Swal.fire('Carrito vacío', 'El carrito ha sido vaciado.', 'success');
      }
    });
  }

  eliminarItem(index: number) {
    const item = this.carrito[index];
    if (item) {
      Swal.fire({
        title: '¿Desea eliminar el producto?',
        text: 'El carrito se quedará sin este producto.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          this.cartService.eliminarItem(index);
        }
      });
    }
  }

  aumentarCantidad(index: number): void {
    this.cartService.aumentarCantidad(index);
  }

  disminuirCantidad(index: number): void {
    const item = this.carrito[index];
    if (item && item.cantidad === 1) {
      Swal.fire({
        title: '¿Desea eliminar el producto?',
        text: 'El carrito se quedará sin este producto.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          this.cartService.disminuirCantidad(index);
        }
      });
    } else {
      this.cartService.disminuirCantidad(index);
    }
  }

  seleccionarCategoria(tipo: string) {
    this.categoriaSeleccionada = tipo;
  }

  limpiarCategoria() {
    this.categoriaSeleccionada = '';
  }

  comprar() {
    const carrito = this.cartService.getCarrito();
    if (carrito.length === 0) {
      Swal.fire({
        icon: 'info',
        title: 'Carrito vacío',
        text: 'Tu carrito está vacío',
        timer: 1500,
        showConfirmButton: false
      });
      return;
    }

    localStorage.setItem('carrito', JSON.stringify(carrito));
    this.router.navigate(['/checkout']);
  }
}
