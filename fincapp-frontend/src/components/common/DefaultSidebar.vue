<template>
  <div class="flex h-screen">
    <aside :class="{
      'w-64': isExpanded,
      'w-8': !isExpanded,
    }" class="bg-gray-800 text-white transition-all duration-300 relative">
      <button @click="toggleSidebar"
        class="absolute top-4 right-0 transform translate-x-1/2 p-2 bg-gray-800 text-white rounded-full focus:outline-none z-10">
        <span v-if="isExpanded">←</span>
        <span v-else>→</span>
      </button>

      <div v-if="isExpanded" class="p-4">
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <nav>
          <ul>
            <li v-for="(menuItem, index) in menuItems" :key="index">
              <div @click="toggleSubmenu(index)"
                class="flex items-center justify-between p-4 hover:bg-gray-700 cursor-pointer">
                <div class="flex items-center">
                  <component :is="menuItem.icon" class="w-5 h-5 mr-2" />
                  {{ menuItem.title }}
                </div>
                <ChevronDown :class="{ 'transform rotate-180': openSubmenu === index }"
                  class="w-4 h-4 transition-transform duration-200" />
              </div>
              <ul v-show="openSubmenu === index" class="bg-gray-900">
                <li v-for="subItem in menuItem.subItems" :key="subItem.title" class="pl-12 py-2 hover:bg-gray-700">
                  <a :href="subItem.link??''" class="block">{{ subItem.title }}</a>
                </li>
              </ul>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

    <main class="flex-1 overflow-y-auto bg-gray-100 container mx-auto py-4">
      <slot></slot>
    </main>
  </div>
</template>

<script setup>
/* eslint-disable */

import { ref } from 'vue';
import {
  Package,
  Users,
  ShoppingCart,
  FileText,
  BarChart2,
  Leaf,
  ChevronDown,
} from 'lucide-vue-next';

const isExpanded = ref(true); // Controla si la sidebar está expandida o no

const toggleSidebar = () => {
  isExpanded.value = !isExpanded.value;
};

const openSubmenu = ref(null);

const toggleSubmenu = (index) => {
  openSubmenu.value = openSubmenu.value === index ? null : index;
};

const menuItems = [
  {
    title: 'Materiales',
    icon: Package,
    subItems: [
      { title: 'Index', link: "materiales" },
    ]
  },
  {
    title: 'Terceros',
    icon: Users,
    subItems: [
      { title: 'Index', link: "terceros" },
    ]
  },
  {
    title: 'Kardexes',
    icon: BarChart2,
    subItems: [
      { title: 'Index', link: "kardexes" },
    ]
  },
  /*{
    title: 'Compras',
    icon: ShoppingCart,
    subItems: [
      { title: 'Consultar' },
      { title: 'Crear' }
    ]
  },
  {
    title: 'Facturas',
    icon: FileText,
    subItems: [
      { title: 'Consultar' },
      { title: 'Crear' }
    ]
  },
  {
    title: 'Cultivos',
    icon: Leaf,
    subItems: [
      { title: 'Consultar' },
      { title: 'Crear' }
    ]
  }*/
]
</script>

<style scoped>
/* Transiciones para el ancho de la sidebar */
aside {
  min-width: 2rem;
  /* Espacio mínimo visible cuando está oculta */
}

button {
  width: 2rem;
  height: 2rem;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
