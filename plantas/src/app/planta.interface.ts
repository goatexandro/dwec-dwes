// planta.interface.ts
export interface Planta {
  nombre: string;
  tipo: 'Arbusto' | 'Árbol';  // Tipo puede ser solo Arbusto o Árbol
  favorito: boolean;  // Para marcar si es favorita
}
