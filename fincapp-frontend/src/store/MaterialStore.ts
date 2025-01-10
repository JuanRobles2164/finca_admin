import { defineStore } from 'pinia';
import MaterialService from '@/services/MaterialService';
import { Material } from '@/models/Material';
import { CreateMaterialRequest } from '@/models/request/material/CreateMaterialRequest';
import { UpdateMaterialRequest } from '@/models/request/material/UpdateMaterialRequest';

const materialService = new MaterialService();

export const useMaterialStore = defineStore('material', {
    state: () => ({
        materiales: [] as Material[],
        loading: false,
        error: null as string | null,
        material : {} as Material,
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
            this.materiales = [] as Material[];
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

        async updateMaterial(material: Material, materialId: number) {
            this.loading = true;
            this.error = null;
            try {
                const materialUpdateRequest: UpdateMaterialRequest = {
                    object_id: materialId,
                    data: material
                };
                await materialService.updateMaterial(materialUpdateRequest);
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