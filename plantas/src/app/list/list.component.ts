import { Component, Input, Output, EventEmitter } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Planta } from '../planta.interface';  

@Component({
  selector: 'app-list',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './list.component.html',
  styleUrls: ['./list.component.scss'],
})
export class ListComponent {
  @Input() plantas: Planta[] = [];  
  @Output() eliminar = new EventEmitter<number>();  
  @Output() favorito = new EventEmitter<Planta>();  

  eliminarPlanta(index: number): void {
    this.eliminar.emit(index);  
  }

  toggleFavorito(planta: Planta): void {  
    this.favorito.emit(planta);  
  }
}
