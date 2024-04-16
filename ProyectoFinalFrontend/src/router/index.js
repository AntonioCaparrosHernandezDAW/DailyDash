import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('@/components/LoginVista.vue')
    },
    {
      path: '/inicio',
      name: 'inicio',
      component: () => import('@/components/MainVista.vue')
    }
  ]
})

export default router;
