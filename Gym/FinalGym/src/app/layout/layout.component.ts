import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FooterComponent } from '../footer/footer.component';
import { RouterModule } from '@angular/router';
import { Router } from '@angular/router';

@Component({
  selector: 'app-layout',
  templateUrl: './layout.component.html',
  styleUrls: ['./layout.component.css'],
  imports: [CommonModule, FooterComponent, RouterModule],
})

export class LayoutComponent {
  colapsado: boolean = true;

  constructor(public router: Router) { }

  toggleSidebar() {
    this.colapsado = !this.colapsado;
  }

  get mostrarFooter(): boolean {
    const ocultarFooter = ['/tienda', '/checkout', '/cuenta'];
    return !ocultarFooter.includes(this.router.url.split('?')[0]);
  }
}
