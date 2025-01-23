import { CONSTANTS } from "@/common/Constants";
import BaseService from "./BaseService";
import { Factura } from "@/models/Factura";
import { FacturaData } from "@/models/pdf/FacturaData";

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

    async getFacturaDetails(factura_id: number) : Promise<FacturaData>{
        return await this.get<FacturaData>(`details/${factura_id}`);
    }
}