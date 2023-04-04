import { createRouter, createWebHistory } from 'vue-router';

import Home from './views/Home.vue';
import Favorite from './views/Favorite.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
  },
  {
    path: '/favorite',
    name: 'about',
    component: Favorite,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;