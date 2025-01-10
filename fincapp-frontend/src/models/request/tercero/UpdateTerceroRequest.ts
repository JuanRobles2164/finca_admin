import { Tercero } from "@/models/Tercero";

export interface UpdateTerceroRequest {
    object_id: number,
    data: Tercero
}