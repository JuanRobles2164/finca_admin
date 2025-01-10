export interface BiometricoMaterial {
    id: number;
    identificador?: number | null;
    edad: number;
    es_padron: boolean;
    sexo: string;
    adquisicion: string;
    padre_id?: number | null;
    material_id: number;
    createdAt: string;
    updatedAt: string;
}