<template>
    <div class="p-4 bg-gray-100 rounded shadow">
      <h2 class="text-xl font-bold mb-4 text-gray-700">Existencia de Materiales</h2>
      <div v-if="loading" class="text-center text-gray-500">Cargando...</div>
      <div v-if="error" class="text-red-500">{{ error }}</div>
      <div v-if="kardexes.length > 0" class="overflow-x-auto">
        <table class="table-auto w-full text-left border border-gray-300">
          <thead>
            <tr class="bg-gray-200 text-gray-700">
              <th class="p-2 border">Material</th>
              <th class="p-2 border">Tipo de material</th>
              <th class="p-2 border">Total inventario</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="kardex in kardexes" :key="kardex.id" class="odd:bg-white even:bg-gray-100">
              <td class="p-2 border">{{ kardex.material }}</td>
              <td class="p-2 border">{{ kardex.tipo_material }}</td>
              <td class="p-2 border">{{ kardex.total_inventario }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>
  
  <script setup>
  import { useKardexStore } from "@/store/KardexStore";
  import { computed, onMounted } from "vue";
  
  const kardexStore = useKardexStore();
  const kardexes = computed(() => kardexStore.kardexes);
  
  onMounted(() => {
    kardexStore.fetchExistenciaMateriales();
  });
  
  const { loading, error } = kardexStore;
  </script>
  