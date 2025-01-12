import { defineStore } from 'pinia';

export const useSidebarStore = defineStore('sidebar', {
  state: () => ({
    isVisible: true,
  }),
  actions: {
    toggleSidebar() {
      this.isVisible = !this.isVisible;
    },
    setSidebarVisibility(visible: boolean) {
      this.isVisible = visible;
    },
  },
});
