import { Component, NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [CommonModule, RouterModule],
  template: `<router-outlet></router-outlet>`, //este es el contenedor que carga el layoutcompnent y este a su vez sus hijos
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'FinalGym';
}
