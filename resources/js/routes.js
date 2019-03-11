import Vue from 'vue';
import VueRouter from 'vue-router';

import UserComponent from '@/js/components/UserComponent';

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'User',
      component: UserComponent
    }
  ]
});

export default router;