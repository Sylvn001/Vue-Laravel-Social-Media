import Vue from 'vue'
import Router from 'vue-router'

import home from '@/pages/home/home'
import login from '@/pages/login/login'
import Cadastro from '@/pages/cadastro/Cadastro'
import perfil from '@/pages/perfil/perfil'
import Pagina from '@/pages/pagina/Pagina'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'home',
      component: home
    }, 
    {
      path: '/pagina/:id/:nome?',
      name: 'Pagina',
      component: Pagina
    },
    {
      path: '/login',
      name: 'login',
      component: login
    }, 
    {
      path: '/cadastro',
      name: 'Cadastro',
      component: Cadastro
    },
    {
      path: '/perfil',
      name: 'perfil',
      component: perfil
    },
  ]
})
