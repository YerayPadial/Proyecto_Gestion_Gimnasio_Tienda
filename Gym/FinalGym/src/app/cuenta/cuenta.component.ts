import { Component, ElementRef, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { firstValueFrom } from 'rxjs';
import { AuthService } from '../services/auth.service';
import { Cliente } from '../interfaces/cliente';
import { QRCodeComponent } from 'angularx-qrcode';

@Component({
  selector: 'app-cuenta',
  standalone: true,
  imports: [FormsModule, CommonModule, QRCodeComponent],
  templateUrl: './cuenta.component.html',
  styleUrl: './cuenta.component.css'
})
export class CuentaComponent implements OnInit {
  identificador: string = '';
  mensaje: string = '';
  error: string = '';
  logueado: boolean = false;
  verificado: boolean = false;
  cliente: Cliente | null = null;
  redirigiendoWorker: boolean = false;
  cargandoCliente: boolean = false;
  qrData: string = '';
  codigoVerificacion = '';
  errorCodigo = '';

  constructor(private authService: AuthService) { }

  ngOnInit(): void {
    const identificadorGuardado = localStorage.getItem('usuarioIdentificador');
    if (identificadorGuardado) {
      this.identificador = identificadorGuardado;
      this.logueado = true;
      this.verificarUsuario();
    }
  }

  async verificarUsuario() {
    this.cargandoCliente = true;
    try {
      const response = await firstValueFrom(this.authService.verificarUsuario(this.identificador));
      switch (response.rol) {
        case 'worker':
          this.redirigiendoWorker = true;
          setTimeout(() => {
            //pasar email facilidad - rutax
            window.location.href = 'https://ieslamarisma.net/proyectos/2025/yeraipadial/gymfinal/public/admin/login';
          }, 1000);

          return;

        case 'cliente':
          this.cliente = response.cliente!;
          if (this.cliente) {
            this.authService.enviarCodigo(this.cliente.dni).subscribe();
            this.mensaje = '';
            if (this.cliente.foto && this.cliente.foto !== 'null' && this.cliente.foto !== 'undefined') {
              this.cliente.foto = 'https://ieslamarisma.net/proyectos/2025/yeraipadial/gymfinal/public/storage/' + this.cliente.foto;//rutax
            } else {
              this.cliente.foto = null;
            }
            this.qrData = JSON.stringify({
              id: this.cliente.id,
              nombre: this.cliente.nombre,
              apellidos: this.cliente.apellidos,
              dni: this.cliente.dni,
              gym: 'FinalGym'
            });
          }
          break;
        default:
          this.mensaje = '¿Aún no eres cliente?';
          this.cliente = null;
      }
    } catch {
      this.mensaje = 'Error al verificar usuario';
    } finally {
      this.cargandoCliente = false;
    }
  }

  login() {
    if (!this.identificador.trim()) {
      this.error = 'Ingrese sus credenciales.';
      return;
    }
    localStorage.setItem('usuarioIdentificador', this.identificador);
    this.logueado = true;
    this.error = '';
    this.verificarUsuario();
  }

  logout() {
    localStorage.removeItem('usuarioIdentificador');
    this.logueado = false;
    this.identificador = '';
    this.mensaje = '';
    this.cliente = null;
  }

  enviarCodigoVerificacion() {
    if (!this.codigoVerificacion || !this.cliente?.dni) return;
    this.authService.verificarCodigo(this.cliente.dni, this.codigoVerificacion).subscribe({
      next: (resp) => {
        if (resp.valid) {
          this.verificado = true;
          this.errorCodigo = '';
        } else {
          this.errorCodigo = 'Código incorrecto';
        }
      },
      error: () => {
        this.errorCodigo = 'Código incorrecto';
      }
    });
  }
}