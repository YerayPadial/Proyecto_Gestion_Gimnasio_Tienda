import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { Producto } from '../interfaces/producto';
import { ProductoService } from '../services/producto.service';
import { CartService } from '../services/cart.service';
import { MatStepperModule } from '@angular/material/stepper';
import { MatInputModule } from '@angular/material/input';
import { MatButtonModule } from '@angular/material/button';
import { MatSelectModule } from '@angular/material/select';
import { MatFormFieldModule } from '@angular/material/form-field';
import { Router } from '@angular/router';
import { firstValueFrom } from 'rxjs';
import { PedidoService } from '../services/pedido.service';
import { AfterViewInit } from '@angular/core';

@Component({
  selector: 'app-checkout',
  standalone: true,
  imports: [
    CommonModule,
    ReactiveFormsModule,
    MatStepperModule,
    MatInputModule,
    MatButtonModule,
    MatSelectModule,
    MatFormFieldModule
  ],
  templateUrl: './checkout.component.html',
  styleUrl: './checkout.component.css'
})
export class CheckoutComponent implements OnInit, AfterViewInit {
  carrito: { producto: Producto; cantidad: number }[] = [];
  checkoutForm!: FormGroup;
  total: number = 0;
  totalIva: number = 0;
  productos: Producto[] = [];

  constructor(
    private fb: FormBuilder,
    private cartService: CartService,
    private productoService: ProductoService,
    private router: Router,
    private pedidoService: PedidoService
  ) { }

  ngOnInit(): void {
    this.carrito = this.cartService.getCarrito();
    this.calcularTotal();
    this.productoService.getProductos().subscribe(data => {
      this.productos = data;
    });
    this.checkoutForm = this.fb.group({
      cliente: this.fb.group({
        nombre: [
          '',
          [
            Validators.required,
            Validators.pattern(/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/)
          ]
        ],
        telefono: [
          '',
          [
            Validators.required,
            Validators.pattern(/^[0-9]{9}$/)
          ]
        ],
        email: [
          '',
          [
            Validators.required,
            Validators.email
          ]
        ],
        dni: [
          '',
          [
            Validators.required,
            Validators.pattern(/^\d{8}[A-Za-z]$/)
          ]
        ]
      }),
      envioTipo: ['recogida'],
      envio: this.fb.group({
        direccion: [''],
        numero: [''],
        provincia: [''],
        municipio: [''],
        pais: [''],
        codigoPostal: ['']
      })
    });

    // segun el tipo de envio
    this.checkoutForm.get('envioTipo')?.valueChanges.subscribe((tipo) => {
      const envioGroup = this.checkoutForm.get('envio') as FormGroup;
      if (tipo === 'envio') {
        envioGroup.get('direccion')?.setValidators([
          Validators.required,
          Validators.pattern(/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/)
        ]);
        envioGroup.get('numero')?.setValidators([
          Validators.required,
          Validators.pattern(/^[0-9]+$/)
        ]);
        envioGroup.get('provincia')?.setValidators([
          Validators.required,
          Validators.pattern(/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/)
        ]);
        envioGroup.get('municipio')?.setValidators([
          Validators.required,
          Validators.pattern(/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/)
        ]);
        envioGroup.get('pais')?.setValidators([
          Validators.required,
          Validators.pattern(/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/)
        ]);
        envioGroup.get('codigoPostal')?.setValidators([
          Validators.required,
          Validators.pattern(/^[0-9]{5}$/)
        ]);
      } else {
        envioGroup.get('direccion')?.clearValidators();
        envioGroup.get('numero')?.clearValidators();
        envioGroup.get('provincia')?.clearValidators();
        envioGroup.get('municipio')?.clearValidators();
        envioGroup.get('pais')?.clearValidators();
        envioGroup.get('codigoPostal')?.clearValidators();
        envioGroup.reset();
      }
      envioGroup.updateValueAndValidity();
    });
  }

  get clienteFormGroup(): FormGroup {
    return this.checkoutForm.get('cliente') as FormGroup;
  }
  get envioFormGroup(): FormGroup {
    return this.checkoutForm.get('envio') as FormGroup;
  }

  cancelarCheckout() {
    this.router.navigate(['/tienda']);
  }

  calcularTotal(): void {
    this.total = this.carrito.reduce((acc, item) => {
      const precio = Number(item.producto.precio) || 0;
      const cantidad = Number(item.cantidad) || 0;
      return acc + precio * cantidad;
    }, 0);
    this.calcularTotalIva()
  }

  calcularTotalIva(): void {
    this.totalIva = this.total * 1.21;
  }

  async comprar() {
    if (this.carrito.length === 0) {
      alert('Tu carrito está vacío');
      return;
    }

    try {
      const productosActuales = await Promise.all(
        this.carrito.map(item =>
          firstValueFrom(this.productoService.getProductoById(item.producto.id))
        )
      );

      const productosSinStock = productosActuales.filter((productoActual, i) => {
        const cantidadEnCarrito = this.carrito[i].cantidad;
        return productoActual.existencias < cantidadEnCarrito;
      });

      if (productosSinStock.length > 0) {
        const nombres = productosSinStock.map(producto => producto.nombre || 'Desconocido'
        ).join(', ');
        alert(`No hay suficientes existencias de los siguientes productos: ${nombres}`);
        this.router.navigate(['/tienda']);
        return;
      }

      // Enviar pedido al backend
      const formData = this.checkoutForm.value;
      const pedidoData = {
        cliente: formData.cliente,
        envioTipo: formData.envioTipo,
        envio: formData.envio,
        productos: this.carrito.map(item => ({
          id: item.producto.id,
          cantidad: item.cantidad
        }))
      };
      await firstValueFrom(this.pedidoService.crearPedido(pedidoData));

      alert('Compra realizada con éxito');
      this.cartService.limpiarCarrito();
      this.carrito = [];
      this.router.navigate(['/tienda']);

    } catch (error) {
      console.error('Error al verificar o actualizar productos:', error);
      alert('Hubo un error al realizar la compra. Intenta nuevamente.');
    }
  }

 ngAfterViewInit(): void {
    this.renderPayPalButton();
  }

  renderPayPalButton(): void {
    // @ts-ignore
    paypal.Buttons({
      createOrder: (data: any, actions: any) => {
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: this.totalIva.toFixed(2)
            }
          }]
        });
      },
      onApprove: async (data: any, actions: any) => {
        try {
          const details = await actions.order.capture();
          console.log('Pago aprobado:', details);
          await this.comprar();
        } catch (error) {
          console.error('Error al capturar el pago:', error);
          alert('Error al capturar el pago con PayPal');
        }
      },
      onError: (err: any) => {
        console.error('Error en PayPal:', err);
        alert('Ocurrió un error con el pago de PayPal. Intenta nuevamente.');
      }
    }).render('#paypal-button-container');
  }

}
