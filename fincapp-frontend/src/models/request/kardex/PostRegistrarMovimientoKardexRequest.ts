import { CONSTANTS } from "@/common/Constants";

export interface PostRegistrarMovimientoKardex {
    material_id: number,
    cantidad: number,
    tipo_movimiento: CONSTANTS.TIPO_MOVIMIENTO_KARDEX_ENTRA | CONSTANTS.TIPO_MOVIMIENTO_KARDEX_SALE
}