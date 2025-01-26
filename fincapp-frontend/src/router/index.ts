import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import MaterialesView from '@/views/MaterialesView.vue'
import DefaultLayout from '@/layouts/DefaultLayout.vue';
import TercerosView from '@/views/TercerosView.vue';
import KardexesView from '@/views/KardexesView.vue';
import FacturasView from '@/views/FacturasView.vue';
import CultivosView from '@/views/CultivosView.vue';

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    component: DefaultLayout,
    children: [
      {
        path: '',
        name: 'home',
        component: HomeView,
      },
      {
        path: 'materiales',
        name: 'materiales',
        component: MaterialesView,
      },
      {
        path: 'terceros',
        name: 'terceros',
        component: TercerosView,
      },
      {
        path: 'kardexes',
        name: 'kardexes',
        component: KardexesView,
      },
      {
        path: 'facturas',
        name: 'facturas',
        component: FacturasView,
      },
      {
        path: 'cultivos',
        name: 'cultivos',
        component: CultivosView,
      },
    ],
  },
  {
    path: '/about',
    name: 'about',
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue'),
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
