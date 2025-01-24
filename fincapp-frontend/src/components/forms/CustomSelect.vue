<template>
    <div class="relative">
      <!-- Input para buscar -->
      <input
        type="text"
        v-model="searchQuery"
        @input="filterOptions"
        @focus="isOpen = true"
        @blur="closeDropdown"
        :placeholder="placeholder"
        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
      />
  
      <!-- Dropdown con opciones -->
      <div
        v-if="isOpen && filteredOptions.length > 0"
        class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto"
      >
        <ul>
          <li
            v-for="(option, index) in filteredOptions"
            :key="index"
            @mousedown="selectOption(option)"
            class="px-4 py-2 hover:bg-indigo-100 cursor-pointer"
          >
            {{ getLabel(option) }}
          </li>
        </ul>
      </div>
  
      <!-- Mensaje si no hay opciones -->
      <div
        v-if="isOpen && filteredOptions.length === 0"
        class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg px-4 py-2 text-gray-500"
      >
        No se encontraron resultados.
      </div>
    </div>
  </template>
  
  <script>
  import { ref, computed } from "vue";
  
  export default {
    props: {
      options: {
        type: Array,
        required: true,
      },
      getLabel: {
        type: Function,
        required: true,
      },
      modelValue: {
        type: Object,
        default: null,
      },
      placeholder: {
        type: String,
        default: "Seleccione una opción",
      },
    },
    emits: ["update:modelValue"], // Emitir evento para v-model
    setup(props, { emit }) {
      // Estado reactivo
      const searchQuery = ref("");
      const isOpen = ref(false);
  
      // Filtrar opciones basadas en la búsqueda
      const filteredOptions = computed(() => {
        return props.options.filter((option) =>
          props.getLabel(option).toLowerCase().includes(searchQuery.value.toLowerCase())
        );
      });
  
      // Seleccionar una opción
      const selectOption = (option) => {
        emit("update:modelValue", option); // Emitir el valor seleccionado
        searchQuery.value = props.getLabel(option); // Mostrar el label seleccionado
        isOpen.value = false; // Cierra el dropdown
      };
  
      // Cerrar el dropdown
      const closeDropdown = () => {
        setTimeout(() => {
          isOpen.value = false;
        }, 200); // Pequeño retraso para permitir la selección
      };
  
      return {
        searchQuery,
        isOpen,
        filteredOptions,
        selectOption,
        closeDropdown,
      };
    },
  };
  </script>