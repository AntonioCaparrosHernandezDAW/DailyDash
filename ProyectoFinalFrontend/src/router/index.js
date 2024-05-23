import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'inicio',
      component: ()=> import('@/views/InicioVista.vue')
    },
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
    },
    {
      path: '/prueba',
      name: 'prueba',
      component: () => import('@/components/TiempoComponent.vue')
    },
  ]
})

export default router;
