import { defineStore } from 'pinia';
import { ref } from 'vue';

interface Notification {
  id: number;
  type: string;
  title: string;
  message: string;
}

export const useNotificationStore = defineStore('notification', () => {
  const notifications = ref<Notification[]>([]);

  const addNotification = (type: string, title: string, message: string) => {
    const id = Date.now();
    notifications.value.push({ id, type, title, message });

    // Remove notification after 5 seconds
    setTimeout(() => {
      removeNotification(id);
    }, 5000);
  };

  const removeNotification = (id: number) => {
    const index = notifications.value.findIndex(
      (notification) => notification.id === id
    );
    if (index !== -1) {
      notifications.value.splice(index, 1);
    }
  };
  

  return { notifications, addNotification, removeNotification };
});
