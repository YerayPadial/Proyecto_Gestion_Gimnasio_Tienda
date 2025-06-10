//defino las propiedades que tiene categoria y producto
//  y asi con .propiedad accedo a ellas
export interface Categoria {
    id: number;
    tipo: string;
    descripcion: string;
    created_at: string;
    updated_at: string;
}

export interface Producto {
    id: number;
    tipo_categoria: number;
    nombre: string;
    precio: string;
    existencias: number;
    descripcion: string;
    foto: string;
    created_at: string;
    updated_at: string;
    categoria: Categoria;
}
