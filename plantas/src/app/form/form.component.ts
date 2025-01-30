import { Component, Output, EventEmitter } from '@angular/core';
import { Planta } from '../planta.interface';  
import { FormsModule } from '@angular/forms';  

@Component({
  selector: 'app-form',
  standalone: true,
  imports: [FormsModule], 
  templateUrl: './form.component.html',
  styleUrls: ['./form.component.scss'],
})
export class FormComponent {
  nombre: string = '';  
  tipo: string = 'Arbusto';  

  @Output() nuevaPlanta = new EventEmitter<Planta>();  

  enviarPlanta(): void {
    if (this.nombre && this.tipo) {
      const planta: Planta = {
        nombre: this.nombre,
        tipo: this.tipo as 'Arbusto' | 'Árbol',  
        favorito: false,
      };
      this.nuevaPlanta.emit(planta);  
      this.nombre = '';  
      this.tipo = 'Arbusto';  
    }
  }

  borrarFormulario(): void {
    this.nombre = '';  
    this.tipo = 'Arbusto';
  }
}
