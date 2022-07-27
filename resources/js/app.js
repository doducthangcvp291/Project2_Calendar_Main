require('./bootstrap');

import Vue from 'vue';
import router from './router.js';
import store from './store/index';
import { initialize } from "./helpers/general";

import App from './App.vue';

initialize(store, router);

const app = new Vue({
    el: '#app',
    router,
    store,
    render: h =>h(App)
});