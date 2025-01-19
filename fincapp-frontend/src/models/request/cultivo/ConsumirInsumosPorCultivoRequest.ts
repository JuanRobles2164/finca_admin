export interface InsumosConsumidos {
    material_id: number,
    cantidad: number,
    nombre: string
}

export interface ConsumirInsumosPorCultivoRequest {
    material_id_cultivo: number,
    insumos_consumidos: InsumosConsumidos[],
}