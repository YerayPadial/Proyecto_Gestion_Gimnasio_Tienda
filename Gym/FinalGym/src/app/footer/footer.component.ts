import { Component, EventEmitter, Output } from '@angular/core';
import { Router } from '@angular/router';
@Component({
  selector: 'app-footer',
  imports: [],
  templateUrl: './footer.component.html',
  styleUrl: './footer.component.css'
})
export class FooterComponent {
  constructor(private router: Router) { }
  irNosotros() {
    this.router.navigate(['/nosotros']);
  }

  irUbicanos() {
    this.router.navigate(['/ubicacion']);
  }

  irInicio() {
    this.router.navigate(['/inicio']);
  }

  irTienda() {
    this.router.navigate(['/tienda']);
  }
}
