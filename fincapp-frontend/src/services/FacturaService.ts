import { CONSTANTS } from "@/common/Constants";
import BaseService from "./BaseService";
import { Factura } from "@/models/Factura";
import { CreateFacturaRequest } from "@/models/request/factura/CreateFacturaRequest";

export default class FacturaService extends BaseService {
    constructor() {
        super(CONSTANTS.BASE_API_URL, CONSTANTS.BASE_API_GROUP.FACTURA);
    }

    async getExistenciaMateriales() : Promise<Factura[]>{
        return await this.get<Factura[]>('/', {});
    }

    async updateUltimoKardexPorMaterial(createFacturaRequest : CreateFacturaRequest) : Promise<Factura>{
        return await this.put<Factura>('create', createFacturaRequest);
    }
}