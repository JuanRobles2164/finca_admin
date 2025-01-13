export interface MaterialesVenta {
    material_id: number,
    cantidad: number,
    valor_unitario: number,
    material_obj: any
}

export interface CreateFacturaRequest {
    materiales_venta : MaterialesVenta[],
    tercero_id: number,
    pagada? : boolean,
    fecha_venta: string
}