<template>
  <transition name="fade" mode="out-in">
    <div v-if="notifications.length" class="fixed top-4 right-4 space-y-4">
      <div v-for="notification in notifications" :key="notification.id" :class="alertClasses(notification.type)"
        class="p-4 rounded shadow-lg text-white relative">
        <div class="flex items-center">
          <div class="flex-shrink-0 mr-3"> 
            <span v-if="notification.type === 'success'">✔️</span> 
            <span v-else-if="notification.type === 'danger'">❌</span>
            <span v-else-if="notification.type === 'secondary'">🔔</span>
            <span v-else-if="notification.type === 'primary'">ℹ️</span>
            <span v-else-if="notification.type === 'info'">💡</span>
            <span v-else-if="notification.type === 'warning'">⚠️</span>
          </div>
          <div>
            <p class="font-bold">{{ notification.title }}</p>
            <p>{{ notification.message }}</p>
          </div>
        </div>
        <button @click="removeNotification(notification.id)"
          class="absolute top-1 right-1 text-2xl leading-none text-white">&times;
        </button>
      </div>
    </div>
  </transition>
</template>

<script lang="ts">
/* eslint-disable */
import { defineComponent } from 'vue';
import { useNotificationStore } from '@/store/components/NotificationStore';

export default defineComponent({
  name: 'Notification',
  setup() {
    const store = useNotificationStore();
    const notifications = store.notifications;

    const alertClasses = (type: string) => {
      switch (type) {
        case 'primary':
          return 'bg-blue-500';
        case 'secondary':
          return 'bg-gray-500';
        case 'warning':
          return 'bg-yellow-500';
        case 'danger':
          return 'bg-red-500';
        case 'success':
          return 'bg-green-500';
        case 'info':
          return 'bg-blue-200 bg-opacity-80';
        default:
          return 'bg-gray-500';
      }
    };

    const removeNotification = (id: number) => {
      store.removeNotification(id);
    };

    return {
      notifications,
      alertClasses,
      removeNotification,
    };
  },
});
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>