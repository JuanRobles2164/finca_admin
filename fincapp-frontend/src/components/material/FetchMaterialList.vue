<template>
    <div class="p-6 bg-gray-100 min-h-screen">
        <h1 class="text-2xl font-bold mb-4">Lista de Materiales</h1>

        <table class="table-auto w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-4">ID</th>
                    <th class="p-4">Nombre</th>
                    <th class="p-4">Descripción</th>
                    <th class="p-4">Unidad</th>
                    <th class="p-4">Tipo de Material</th>
                    <th class="p-4">Requiere Procesar</th>
                    <th class="p-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="material in materiales" :key="material.id" class="border-t">
                    <td class="p-4">{{ material.id }}</td>
                    <td class="p-4">{{ material.nombre }}</td>
                    <td class="p-4">{{ material.descripcion }}</td>
                    <td class="p-4">{{ material.unidad }}</td>
                    <td class="p-4">{{ material.tipo_material }}</td>
                    <td class="p-4">{{ material.requiere_procesar ? 'Sí' : 'No' }}</td>
                    <td class="p-4 flex space-x-2">
                        <!-- Botón para ver detalles -->
                        <button @click="openModal('details', material)"
                            class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700">
                            <span>👁</span>
                        </button>
                        <!-- Botón para editar -->
                        <button @click="openModal('edit', material)"
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
                    {{ modalType === 'details' ? 'Detalles del Material' : 'Editar Material' }}
                </h2>
                <div v-if="modalType === 'details'">
                    <p><strong>ID:</strong> {{ selectedMaterial.id }}</p>
                    <p><strong>Nombre:</strong> {{ selectedMaterial.nombre }}</p>
                    <p><strong>Descripción:</strong> {{ selectedMaterial.descripcion }}</p>
                    <p><strong>Unidad:</strong> {{ selectedMaterial.unidad }}</p>
                    <p><strong>Tipo de Material:</strong> {{ selectedMaterial.tipo_material }}</p>
                    <p>
                        <strong>Requiere Procesar:</strong>
                        {{ selectedMaterial.requiere_procesar ? 'Sí' : 'No' }}
                    </p>
                </div>
                <div v-if="modalType === 'edit'">
                    <!-- Formulario de edición -->
                    <label class="block mb-2">
                        Nombre:
                        <input v-model="selectedMaterial.nombre" type="text" class="w-full border rounded p-2" />
                    </label>
                    <label class="block mb-2">
                        Descripción:
                        <textarea v-model="selectedMaterial.descripcion" class="w-full border rounded p-2"></textarea>
                    </label>
                    <label class="block mb-2">
                        Unidad:
                        <select id="unidad" v-model="selectedMaterial.unidad"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option v-for="u in unidades" :key="u" :value="u">{{ u }}</option>
                        </select>
                    </label>
                    <label class="block mb-2">
                        Tipo de Material:
                        <select id="tipo_material" v-model="selectedMaterial.tipo_material" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option v-for="t in tipos_material" :key="t" :value="t">{{ t }}</option>
                        </select>
                    </label>
                    <label class="block mb-2">
                        Requiere Procesar:
                        <input v-model="selectedMaterial.requiere_procesar" type="checkbox" class="mr-2" />
                        Sí
                    </label>
                    <button @click="saveMaterial" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
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

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useMaterialStore } from '@/store/MaterialStore';

let materialParameter = {
    id: 0,
    nombre: '',
    descripcion: '',
    unidad: '',
    tipo_material: '',
    requiere_procesar: false,
};

const materialStore = useMaterialStore();

onMounted(() => {
    materialStore.fetchMateriales();
})

const materiales = computed(() => materialStore.materiales);
const tipos_material = materialStore.tipos_material;
const unidades = materialStore.unidades;

const isModalOpen = ref(false);
const modalType = ref('');
const selectedMaterial = ref({ ...materialParameter });

const openModal = (type, material) => {
    modalType.value = type;
    selectedMaterial.value = { ...material };
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    modalType.value = '';
    selectedMaterial.value = { ...materialParameter };
};

const saveMaterial = async () => {
    await materialStore.updateMaterial({
        object_id: selectedMaterial.value.id,
        data: selectedMaterial.value
    });
    closeModal();
};
</script>

<style scoped></style>