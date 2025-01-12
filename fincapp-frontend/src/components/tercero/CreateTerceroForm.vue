<template>
    <div>
        <button @click="openModal" class="bg-blue-500 text-white px-4 py-2 rounded">
            Crear Tercero
        </button>

        <transition name="modal">
            <div v-if="isOpen" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center"
                @click.self="closeModal">
                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Crear Tercero</h3>
                        <button @click="closeModal" class="text-gray-500 hover:text-gray-700">&times;</button>
                    </div>
                    <div>
                        <form @submit.prevent="handleSubmit" class="space-y-6 bg-white p-6 rounded-lg shadow-md">
                            <div class="flex flex-col">
                                <label for="nombre" class="mb-2 text-sm font-medium text-gray-700">Nombre</label>
                                <input type="text" id="nombre" v-model="tercero.data.nombre"
                                    placeholder="Ingrese el nombre" required
                                    class="p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                            </div>

                            <div class="flex flex-col">
                                <label for="nit" class="mb-2 text-sm font-medium text-gray-700">NIT</label>
                                <input type="text" id="nit" v-model="tercero.data.nit" placeholder="Ingrese el NIT"
                                    required
                                    class="p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                            </div>

                            <div class="flex flex-col">
                                <label for="contacto" class="mb-2 text-sm font-medium text-gray-700">Contacto</label>
                                <input type="text" id="contacto" v-model="tercero.data.contacto"
                                    placeholder="Ingrese el contacto" required
                                    class="p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                            </div>

                            <div class="flex justify-end space-x-4">
                                <button type="submit"
                                    class="px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                                    Guardar
                                </button>
                                <button type="button" @click="closeModal"
                                    class="px-5 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script lang="ts">


import { CreateTerceroRequest } from '@/models/request/tercero/CreateTerceroRequest';
import { Tercero } from '@/models/Tercero';
import { useTerceroStore } from '@/store/TerceroStore';
import { defineComponent, ref } from 'vue';

export default defineComponent({
    name: 'CreateTerceroForm',
    setup() {
        const store = useTerceroStore();
        const isOpen = ref(false);
        let terceroParameter: Tercero = {
            id: 0,
            nombre: '',
            nit: '',
            contacto: ''
        };

        const tercero = ref<CreateTerceroRequest>({
            data: terceroParameter
        });

        const openModal = () => {
            isOpen.value = true;
        };

        const closeModal = () => {
            isOpen.value = false;
            terceroParameter = {
                id: 0,
                nombre: '',
                nit: '',
                contacto: ''
            }
        };

        const handleSubmit = async () => {
            await store.createObject(tercero.value);
            closeModal();
        };

        return {
            isOpen,
            tercero,
            openModal,
            closeModal,
            handleSubmit
        };
    },
});
</script>
<style lang="">

</style>