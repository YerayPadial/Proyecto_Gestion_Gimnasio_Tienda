import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LayoutComponent } from './layout/layout.component';
import { InicioComponent } from './inicio/inicio.component';
import { SobreUsComponent } from './sobre-us/sobre-us.component';
import { UbicanosComponent } from './ubicanos/ubicanos.component';
import { ArticulosComponent } from './articulos/articulos.component';
import { CuentaComponent } from './cuenta/cuenta.component';
import { CheckoutComponent } from './checkout/checkout.component';

export const routes: Routes = [
  {
    path: '',
    component: LayoutComponent, // este es el padre que contiene el menu (con hijos a elegir) y el footer
    children: [
      { path: '', redirectTo: 'inicio', pathMatch: 'full' },
      { path: 'inicio', component: InicioComponent },
      { path: 'ubicacion', component: UbicanosComponent },
      { path: 'nosotros', component: SobreUsComponent },
      { path: 'tienda', component: ArticulosComponent },
      { path: 'cuenta', component: CuentaComponent },
      { path: 'checkout', component: CheckoutComponent }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule {}
