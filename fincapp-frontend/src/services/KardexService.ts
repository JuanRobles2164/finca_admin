import { CONSTANTS } from "@/common/Constants";
import BaseService from "./BaseService";
import { KardexMaterial } from "@/models/response/kardex/KardexMaterial";
import { UpdateKardexRequest } from "@/models/request/kardex/UpdateKardexRequest";
import { PostRegistrarMovimientoKardex } from "@/models/request/kardex/PostRegistrarMovimientoKardexRequest";

export default class KardexService extends BaseService {
    constructor(){
        super(CONSTANTS.BASE_API_URL, CONSTANTS.BASE_API_GROUP.KARDEX);
    }

    async getExistenciaMateriales() : Promise<KardexMaterial[]>{
        return await this.get<KardexMaterial[]>('listar-existencia-materiales', {});
    }

    async updateUltimoKardexPorMaterial(updateKardexRequest : UpdateKardexRequest) : Promise<boolean>{
        return await this.put<boolean>('editar-ultimo-kardex-por-material', updateKardexRequest);
    }

    async postRegistrarMovimientoKardex(postRegistrarMovimientoKardex : PostRegistrarMovimientoKardex) : Promise<boolean> {
        return await this.post<boolean>('registrar-movimiento-kardex', postRegistrarMovimientoKardex);
    }
}