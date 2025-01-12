import { CONSTANTS } from "@/common/Constants";
import BaseService from "./BaseService";
import { Tercero } from "@/models/Tercero";
import { CreateTerceroRequest } from "@/models/request/tercero/CreateTerceroRequest";
import { UpdateTerceroRequest } from "@/models/request/tercero/UpdateTerceroRequest";

export default class TerceroService extends BaseService {

    constructor() {
        super(CONSTANTS.BASE_API_URL, CONSTANTS.BASE_API_GROUP.TERCEROS);
    }

    async getObjects(): Promise<Tercero[]> {
        return await this.get('/', {});
    }

    async createObject(createObjectRequest: CreateTerceroRequest): Promise<Tercero> {
        const response = await this.post<Tercero>('create', createObjectRequest);
        this.successOperationNotification();
        return response;
    }

    async updateObject(updateObjectRequest: UpdateTerceroRequest): Promise<boolean> {
        const response = await this.put<boolean>('update', updateObjectRequest)
        this.successOperationNotification();
        return response;
    }

    async findTercero(id: number): Promise<Tercero> {
        return await this.get(`find/${id}`);
    }
}