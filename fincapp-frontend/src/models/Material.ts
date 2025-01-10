export interface Material {
    id?: number;
    nombre: string;
    descripcion?: string;
    unidad: string;
    tipo_material: string;
    requiere_procesar: boolean;
    createdAt?: string;
    updatedAt?: string;
}