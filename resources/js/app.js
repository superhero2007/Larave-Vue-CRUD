import './bootstrap';
import Vue from 'vue';
import Vuetifyjs from 'vuetify';
import axios from 'axios'

import router from '@/js/routes.js';
import { store } from './store'

import App from '@/js/views/App';

Vue.use(Vuetifyjs);
window.axios = require('axios')

const app = new Vue({
  el: '#app',
  store,
  router,
  render: h => h(App),
});

export default app;