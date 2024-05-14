import { defineStore } from 'pinia';

export const userDataStore = defineStore('myStore', {
  state: () => ({
    userData: null,
  }),
  actions: {
    setUserData(userData) {
      this.userData = userData;
    },
  },
});