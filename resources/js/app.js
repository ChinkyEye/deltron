require('./bootstrap');

window.Vue = require('vue');
Vue.config.productionTip = false;

import VueHtmlToPaper from 'vue-html-to-paper';

// register jw pagination component globally
import JwPagination from 'jw-vue-pagination';
Vue.component('jw-pagination', JwPagination);

const options = {
  name: '_blank',
  specs: [
    'fullscreen=yes',
    'titlebar=yes',
    'scrollbars=yes'
  ],
  styles: [
    'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
    'https://unpkg.com/kidlat-css/css/kidlat.css',
    'https://biratkitchen.com.np/css/print.css',
  ]
}
Vue.use(VueHtmlToPaper, options);

// vue router
import VueRouter from 'vue-router'
import VueBodyClass from 'vue-body-class';
Vue.use(VueRouter)

Vue.component('admin-main', require('./components/admin/ManagerMaster.vue').default);
Vue.component('sidebar', require('./components/admin/Sidebar.vue').default);
Vue.component('header-report', require('./components/admin/HeaderReport.vue').default);


import Vuex from 'vuex'
Vue.use(Vuex)

import vSelect from 'vue-select'
Vue.component('v-select', vSelect)

import storeData from './store/index'
const store = new Vuex.Store(
  storeData
)

// import from page
require('./progressbar');

//Import Sweetalert2
import Swal from 'sweetalert2'
window.Swal = Swal
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 1000,
  timerProgressBar: false,
  onOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})
window.Toast = Toast

//Import v-from
import { Form, HasError, AlertError } from 'vform'
import { serialize } from 'object-to-formdata';

window.Form = Form;
window.objectToFormData = serialize;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import {routes} from './routes';
import {filter} from './filter'

const router = new VueRouter({
    routes, // short for `routes: routes`
    mode:'hash',
});

const vueBodyClass = new VueBodyClass(routes);
router.beforeEach((to, from, next) => { vueBodyClass.guard(to, next) });

const app = new Vue({
    el: '#app',
    router,
    store,
});