import { CONSTANTS } from "@/common/Constants";
import BaseService from "./BaseService";
import { KardexMaterial } from "@/models/response/kardex/KardexMaterial";
import { UpdateKardexRequest } from "@/models/request/kardex/UpdateKardexRequest";
import { PostRegistrarMovimientoKardex } from "@/models/request/kardex/PostRegistrarMovimientoKardexRequest";

export default class KardexService extends BaseService {
    constructor(){
        super(CONSTANTS.BASE_API_URL, CONSTANTS.BASE_API_GROUP_KARDEX);
    }

    async getExistenciaMateriales() : Promise<KardexMaterial[]>{
        const response = await this.get<KardexMaterial[]>('listar-existencia-materiales', {});
        this.successOperationNotification();
        return response;
    }

    async updateUltimoKardexPorMaterial(updateKardexRequest : UpdateKardexRequest) : Promise<boolean>{
        const response = await this.put<boolean>('editar-ultimo-kardex-por-material', updateKardexRequest);
        if(response){
            this.successOperationNotification();
        }else{
            this.dangerOperationNotification();
        }
        return response;
    }

    async postRegistrarMovimientoKardex(postRegistrarMovimientoKardex : PostRegistrarMovimientoKardex) : Promise<boolean> {
        const response = await this.post<boolean>('registrar-movimiento-kardex', postRegistrarMovimientoKardex);
        if(response){
            this.successOperationNotification();
        }else{
            this.dangerOperationNotification();
        }
        return response;
    }
}