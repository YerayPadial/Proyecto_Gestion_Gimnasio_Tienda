import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-cuenta',
  imports: [FormsModule, CommonModule],
  templateUrl: './cuenta.component.html',
  styleUrl: './cuenta.component.css'
})
export class CuentaComponent {
  currentView: 'login' | 'register' | 'forgot' = 'login';

  loginData = { usuario: '', password: '' };
  registerData = { usuario: '', correo: '', password: '', repeatPassword: '' };
  forgotPasswordData = { correo: '' };

  alerta: string = '';
  alertaRegistro: string = '';
  alertaCambioPass: string = '';

  showPassword: boolean = false;

  constructor() {}

  switchView(view: 'login' | 'register' | 'forgot') {
    this.currentView = view;
    this.clearAlerts();
  }

  togglePasswordVisibility() {
    this.showPassword = !this.showPassword;
  }

  onLoginSubmit(event: Event) {
    event.preventDefault();
    if (this.loginData.usuario && this.loginData.password) {
      // Aquí llamas a tu API real
      console.log('Login data', this.loginData);

      if (this.loginData.usuario === 'admin' && this.loginData.password === 'admin') {
        this.alerta = '<div class="alert alert-success">Bienvenido</div>';
      } else {
        this.alerta = '<div class="alert alert-danger">Datos incorrectos</div>';
      }
    } else {
      this.alerta = '<div class="alert alert-danger">Complete todos los campos</div>';
    }
  }

  onRegisterSubmit(event: Event) {
    event.preventDefault();
    if (this.registerData.password !== this.registerData.repeatPassword) {
      this.alertaRegistro = '<div class="alert alert-danger">Las contraseñas no coinciden</div>';
    } else {
      // Aquí llamas a tu API real de registro
      console.log('Register data', this.registerData);
      this.alertaRegistro = '<div class="alert alert-success">Registro exitoso</div>';
    }
  }

  onForgotPasswordSubmit(event: Event) {
    event.preventDefault();
    if (this.forgotPasswordData.correo) {
      // Aquí llamarías a tu API de cambio de contraseña
      console.log('Forgot password data', this.forgotPasswordData);
      this.alertaCambioPass = '<div class="alert alert-success">Revisa tu correo</div>';
    } else {
      this.alertaCambioPass = '<div class="alert alert-danger">Ingrese su correo</div>';
    }
  }

  clearAlerts() {
    this.alerta = '';
    this.alertaRegistro = '';
    this.alertaCambioPass = '';
  }
}
