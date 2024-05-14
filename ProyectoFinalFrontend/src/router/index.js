import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: () => import('@/components/LoginVista.vue')
    },
    {
      path: '/panel',
      name: 'panel',
      component: () => import('@/components/MainVista.vue')
    },
    {
      path: '/perfil',
      name: 'perfil',
      component: () => import('@/components/PerfilVista.vue')
    }
  ]
})

export default router;
