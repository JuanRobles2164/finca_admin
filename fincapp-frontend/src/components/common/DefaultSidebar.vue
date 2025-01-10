<template>
  <div class="flex h-screen">
    <aside class="w-64 bg-gray-800 text-white">
      <div class="p-4">
        <h1 class="text-2xl font-bold">Dashboard</h1>
      </div>
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
                <a href="#" class="block">{{ subItem.title }}</a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
    </aside>
    <main class="flex-1 overflow-y-auto bg-gray-100">
      <slot></slot>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import {
  Package, Users, ShoppingCart, FileText, BarChart2, Leaf,
  ChevronDown
} from 'lucide-vue-next'

const openSubmenu = ref(null)

const toggleSubmenu = (index) => {
  openSubmenu.value = openSubmenu.value === index ? null : index
}

const menuItems = [
  {
    title: 'Materiales',
    icon: Package,
    subItems: [
      { title: 'Consultar' },
      { title: 'Crear' }
    ]
  },
  {
    title: 'Terceros',
    icon: Users,
    subItems: [
      { title: 'Consultar' },
      { title: 'Crear' }
    ]
  },
  {
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
    title: 'Kardexes',
    icon: BarChart2,
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
  }
]
</script>