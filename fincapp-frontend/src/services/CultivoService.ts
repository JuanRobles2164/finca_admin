import { CONSTANTS } from "@/common/Constants";
import BaseService from "./BaseService";
import { AgregarCultivoRequest } from "@/models/request/cultivo/AgregarCultivoRequest";
import { ConsumirInsumosPorCultivoRequest } from "@/models/request/cultivo/ConsumirInsumosPorCultivoRequest";
import { RecogerCosechaRequest } from "@/models/request/cultivo/RecogerCosechaRequest";
import { finalizarCosechaRequest } from "@/models/request/cultivo/FinalizarCosechaRequest";
import { Material } from "@/models/Material";
import { CultivoVigente } from "@/models/response/cultivo/CultivosVigente";
import { MaterialProcesable } from "@/models/response/cultivo/MaterialProcesable";

export default class CultivoService extends BaseService {
    constructor() {
        super(CONSTANTS.BASE_API_URL, CONSTANTS.BASE_API_GROUP.CULTIVOS);
    }

    async listarMaterialesDisponiblesParaCultivo() : Promise<Material[]>{
        return await this.get("materiales-disponibles", {});
    }

    async agregarCultivo(agregarCultivoRequest : AgregarCultivoRequest){
        return await this.post("agregar", agregarCultivoRequest);
    }

    async consumirInsumosPorCultivo(consumirInsumosRequest : ConsumirInsumosPorCultivoRequest){
        return await this.post("consumir-insumos", consumirInsumosRequest);
    }

    async recogerCosecha(recogerCosechaRequest : RecogerCosechaRequest){
        return await this.post("recoger-cosecha", recogerCosechaRequest);
    }

    async listarMaterialesProcesables() : Promise<MaterialProcesable[]>{
        return await this.get("materiales-procesables", {});
    }

    async finalizarCosecha(finalizarCosechaRequest : finalizarCosechaRequest){
        return await this.post("finalizar-cosecha", finalizarCosechaRequest);
    }

    async listarCultivosVigentes() : Promise<CultivoVigente[]>{
        return await this.get<CultivoVigente[]>("listar-cultivos-vigentes", {});
    }
}