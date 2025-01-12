import { Material } from '@/models/Material';
import BaseService from './BaseService';
import { CONSTANTS } from '@/common/Constants';
import { CreateMaterialRequest } from '@/models/request/material/CreateMaterialRequest';
import { UpdateMaterialRequest } from '@/models/request/material/UpdateMaterialRequest';

export default class MaterialService extends BaseService {

    constructor() {
        super(CONSTANTS.BASE_API_URL, CONSTANTS.BASE_API_GROUP.MATERIAL);
    }

    async getMateriales(): Promise<Material[]> {
        return await this.get('/', {});
    }

    async createMaterial(materialRequest: CreateMaterialRequest): Promise<Material> {
        const response = await this.post<Material>('create', materialRequest);
        this.successOperationNotification();
        return response;
    }

    async updateMaterial(materialUpdate: UpdateMaterialRequest) : Promise <Material> {
        const response = await this.put<Material>('update', materialUpdate)
        this.successOperationNotification();
        console.log(response);
        return response;
    }

    async findMaterial(materialId : number) : Promise<Material> {
        return await this.get(`find/${materialId}`);
    }
}