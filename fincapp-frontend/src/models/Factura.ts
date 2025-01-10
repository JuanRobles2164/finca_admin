export interface Factura {
    id: number;
    fecha_venta: string;
    numero: number;
    fecha_pago?: string | null;
    estado: string;
    total?: number | null;
    tercero_id: number;
    createdAt: string;
    updatedAt: string;
}
