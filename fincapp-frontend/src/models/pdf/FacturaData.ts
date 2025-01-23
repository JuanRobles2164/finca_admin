import { Factura } from "../Factura";
import { Tercero } from "../Tercero";

export interface VentaMaterial {
    nombre: string;
    cantidad: number;
    valor_unitario: number;
}

export interface FacturaData {
    cliente: Tercero;
    venta_materiales: VentaMaterial[];
    factura: Factura;
    evidencia: string[];
    logo_empresa?: string;
    telefono_empresa?: string;
    direccion_empresa?: string;
}