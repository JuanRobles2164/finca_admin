import { CONSTANTS } from "@/common/Constants";
import BaseService from "./BaseService";
import { Factura } from "@/models/Factura";

export default class FacturaService extends BaseService {
    constructor() {
        super(CONSTANTS.BASE_API_URL, CONSTANTS.BASE_API_GROUP.FACTURA);
    }

    async getExistenciaFacturas() : Promise<Factura[]>{
        return await this.get<Factura[]>('/', {});
    }

    async postRegistrarVenta(formData: FormData): Promise<Factura> {
        return await this.create<Factura>('create', formData);
    }

    async getFacturaDetails(factura_id: number): Promise<Blob> {
        const response = await fetch(`${CONSTANTS.BASE_API_URL}${CONSTANTS.BASE_API_GROUP.FACTURA}details/${factura_id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Error al obtener los detalles de la factura');
        }

        return await response.blob();
    }
}