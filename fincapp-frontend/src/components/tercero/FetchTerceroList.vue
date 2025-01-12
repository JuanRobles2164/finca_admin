<template>
    <div class="p-6 bg-gray-100 min-h-screen">
        <h1 class="text-2xl font-bold mb-4">Lista de Terceros</h1>

        <table class="table-auto w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-4">ID</th>
                    <th class="p-4">Nombre</th>
                    <th class="p-4">Contacto</th>
                    <th class="p-4">Nit</th>
                    
                    <th class="p-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="tercero in terceros" :key="tercero.id" class="border-t">
                    <td class="p-4">{{ tercero.id }}</td>
                    <td class="p-4">{{ tercero.nombre }}</td>
                    <td class="p-4">{{ tercero.contacto }}</td>
                    <td class="p-4">{{ tercero.nit }}</td>
                    <td class="p-4 flex space-x-2">
                        <!-- Botón para ver detalles -->
                        <button @click="openModal('details', tercero)"
                            class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700">
                            <span>👁</span>
                        </button>
                        <!-- Botón para editar -->
                        <button @click="openModal('edit', tercero)"
                            class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-700">
                            <span>✏️</span>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal -->
        <div v-if="isModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded shadow-lg w-1/3">
                <h2 class="text-xl font-bold mb-4">
                    {{ modalType === 'details' ? 'Detalles' : 'Editar' }}
                </h2>
                <div v-if="modalType === 'details'">
                    <p><strong>ID:</strong> {{ selectedTercero.id }}</p>
                    <p><strong>Nombre:</strong> {{ selectedTercero.nombre }}</p>
                    <p><strong>Contacto:</strong> {{ selectedTercero.contacto }}</p>
                    <p><strong>Nit:</strong> {{ selectedTercero.nit }}</p>
                </div>
                <div v-if="modalType === 'edit'">
                    <!-- Formulario de edición -->
                    <label class="block mb-2">
                        Nombre:
                        <input v-model="selectedTercero.nombre" type="text" class="w-full border rounded p-2" />
                    </label>
                    <label class="block mb-2">
                        Contacto:
                        <input v-model="selectedTercero.contacto" type="text" class="w-full border rounded p-2" />
                    </label>
                    <label class="block mb-2">
                        Nit:
                        <input v-model="selectedTercero.nit" type="text" class="w-full border rounded p-2" />
                    </label>
                    <button @click="saveTercero" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
                        Guardar
                    </button>
                </div>
                <button @click="closeModal" class="bg-red-500 text-white px-4 py-2 mt-4 rounded hover:bg-red-700">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';
import { Tercero } from '@/models/Tercero';
import { useTerceroStore } from '@/store/TerceroStore';

let terceroParameter: Tercero = {
    id: 0,
    nombre: '',
    contacto: '',
    nit: '',
};

const store = useTerceroStore();
store.fetch();

const terceros = computed(() => store.terceros);

const isModalOpen = ref(false);
const modalType = ref('');
const selectedTercero = ref({ ...terceroParameter });

const openModal = (type: string, tercero: Tercero) => {
    modalType.value = type;
    selectedTercero.value = { ...tercero };
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    modalType.value = '';
    selectedTercero.value = { ...terceroParameter };
};

const saveTercero = async () => {
    await store.updateObject({
        data: selectedTercero.value,
        object_id: selectedTercero.value.id,
    });
    closeModal();
};
</script>

<style lang="css" scoped>

</style>