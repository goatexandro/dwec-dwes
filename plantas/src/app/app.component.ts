import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormComponent } from './form/form.component';
import { ListComponent } from './list/list.component';
import { Planta } from './planta.interface';  

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [CommonModule, FormComponent, ListComponent],  
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss'],
})
export class AppComponent {
  plantas: Planta[] = [];  

  agregarPlanta(planta: Planta) {  
    this.plantas.push({ ...planta, favorito: false });
    this.plantas.sort((a, b) => a.nombre.localeCompare(b.nombre));  
  }

  eliminarPlanta(index: number): void {
    this.plantas.splice(index, 1);  
  }

  toggleFavorito(planta: Planta): void {
    planta.favorito = !planta.favorito;  
  }
}
