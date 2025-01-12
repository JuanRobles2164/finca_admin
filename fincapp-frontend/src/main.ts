import { createApp } from 'vue';
import App from './App.vue';
import './registerServiceWorker';
import router from './router';
import { createPinia } from 'pinia';

import './styles.css';

const pinia = createPinia(); // Crear instancia de Pinia

createApp(App)
  .use(pinia) // Registrar Pinia
  .use(router) // Registrar router
  .mount('#app');
