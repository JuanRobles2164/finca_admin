<template>
    <div>
        <button @click="openModal" class="bg-blue-500 text-white px-4 py-2 rounded">Crear Material</button>

        <transition name="modal">
            <div v-if="isOpen" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center"
                @click.self="closeModal">
                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Crear Nuevo Material</h3>
                        <button @click="closeModal" class="text-gray-500 hover:text-gray-700">&times;</button>
                    </div>
                    <div>
                        <form @submit.prevent="handleSubmit">
                            <div class="mb-4">°
                                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                                <input type="text" v-model="material.data.nombre" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                            </div>
                            <div class="mb-4">
                                <label for="descripcion"
                                    class="block text-sm font-medium text-gray-700">Descripción</label>
                                <textarea v-model="material.data.descripcion"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="unidad" class="block text-sm font-medium text-gray-700">Unidad</label>
                                <input type="text" v-model="material.data.unidad" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                            </div>
                            <div class="mb-4">
                                <label for="tipo_material" class="block text-sm font-medium text-gray-700">Tipo de
                                    Material</label>
                                <input type="text" v-model="material.data.tipo_material" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                            </div>
                            <div class="mb-4">
                                <label for="requiere_procesar" class="block text-sm font-medium text-gray-700">Requiere
                                    Procesar</label>
                                <input type="checkbox" v-model="material.data.requiere_procesar" class="mt-1" />
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Crear</button>
                                <button @click="closeModal" type="button"
                                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import { useMaterialStore } from '@/store/MaterialStore';
import { CreateMaterialRequest } from '@/models/request/material/CreateMaterialRequest';
import { Material } from '@/models/Material';
import { useNotificationStore } from '@/store/components/NotificationStore';

export default defineComponent({
    name: 'CreateMaterialForm',
    setup() {
        const store = useMaterialStore();
        const isOpen = ref(false);
        let materialParameter: Material = {
            id: 0,
            nombre: '',
            descripcion: '',
            unidad: '',
            tipo_material: '',
            requiere_procesar: false,
        };

        const material = ref<CreateMaterialRequest>({
            data: materialParameter
        });

        const openModal = () => {
            isOpen.value = true;
            showNotification("success", "componente creado con éxito", "FUNCIONAAAAAAAAA!");
        };

        const closeModal = () => {
            isOpen.value = false;
        };

        const handleSubmit = async () => {
            await store.createMaterial(material.value);
            closeModal();
        };

        const notiStore = useNotificationStore(); 
        const showNotification = (type: string, title: string, message: string) => { notiStore.addNotification(type, title, message); };
        return {
            isOpen,
            material,
            openModal,
            closeModal,
            handleSubmit,
            showNotification
        };
    },
});
</script>

<style scoped>

</style>