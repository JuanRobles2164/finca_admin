import { Material } from "@/models/Material";

export interface UpdateMaterialRequest {
    object_id : number,
    data : Material
}