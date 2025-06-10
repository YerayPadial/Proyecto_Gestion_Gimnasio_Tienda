export interface Cliente {
    id: number;
    nombre: string;
    apellidos: string;
    telefono: string;
    dni: string;
    fecha_inicio: string;
    fecha_caducidad: string;
    tipo_cuota: string;
    foto: string | null;
}
