import { defineStore } from 'pinia';
import MaterialService from '@/services/MaterialService';
import { Material } from '@/models/Material';
import { CreateMaterialRequest } from '@/models/request/material/CreateMaterialRequest';
import { UpdateMaterialRequest } from '@/models/request/material/UpdateMaterialRequest';
import { CONSTANTS } from '@/common/Constants';

const materialService = new MaterialService();

export const useMaterialStore = defineStore('material', {
    state: () => ({
        materiales: [] as Material[],
        loading: false,
        error: null as string | null,
        material : {} as Material,
        unidades : CONSTANTS.MATERIALES.UNIDADES,
        tipos_material : CONSTANTS.MATERIALES.TIPOS_MATERIAL
    }),

    actions: {
        async fetchMateriales() {
            this.loading = true;
            this.error = null;
            try {
                this.materiales = await materialService.getMateriales();
            } catch (error) {
                this.error = 'Error al cargar los materiales';
                console.error(error);
            } finally {
                this.loading = false;
            }
        },

        async createMaterial(material: CreateMaterialRequest) {
            this.loading = true;
            this.error = null;
            try {
                const newMaterial = await materialService.createMaterial(material);
                this.materiales.push(newMaterial);
            } catch (error) {
                this.error = 'Error al crear el material';
                console.error(error);
            } finally {
                this.loading = false;
            }
        },

        async updateMaterial(materialUpdateRequest: UpdateMaterialRequest) {
            this.loading = true;
            this.error = null;
            try {

                await materialService.updateMaterial(materialUpdateRequest);

                const index = this.materiales.findIndex((m) => m.id === materialUpdateRequest.object_id);
                console.log(index);
                if (index !== -1) {
                    this.materiales[index] = { ...this.materiales[index], ...materialUpdateRequest.data };
                }
            } catch (error) {
                this.error = 'Error al actualizar el material';
                console.error(error);
            } finally {
                this.loading = false;
            }
        },
        async findMaterial(materialId: number) {
            this.loading = true;
            this.error = null;
            this.material = {} as Material;
            try {
                this.material = await materialService.findMaterial(materialId);
            } catch (error) {
                this.error = 'Error al actualizar el material';
                console.error(error);
            } finally {
                this.loading = false;
            }
        }
    },
});