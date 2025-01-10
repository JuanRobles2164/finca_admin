import { Material } from "@/models/Material";

export interface CreateCompraRequest {
    materiales_compra: Material[],
    tercero_id: number,
    fecha_compra: string
}