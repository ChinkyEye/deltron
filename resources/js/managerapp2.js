/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
Vue.config.productionTip = false;


// register jw pagination component globally
import JwPagination from 'jw-vue-pagination';
Vue.component('jw-pagination', JwPagination);

import VueHtmlToPaper from 'vue-html-to-paper';

const options = {
  name: '_blank',
  specs: [
    'fullscreen=yes',
    'titlebar=yes',
    'scrollbars=yes'
  ],
  styles: [
    'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
    'https://unpkg.com/kidlat-css/css/kidlat.css'
  ],
  timeout: 1000, // default timeout before the print window appears
  autoClose: true, // if false, the window will not close after printing
  windowTitle: window.document.title, // override the window title
}
Vue.use(VueHtmlToPaper,options);


import VueRouter from 'vue-router'
import VueBodyClass from 'vue-body-class';
Vue.use(VueRouter)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('sidebar', require('./components/manager/Sidebar.vue').default);
Vue.component('manager-main', require('./components/Manager/ManagerMaster.vue').default);
Vue.component('header-report', require('./components/manager/HeaderReport.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
 import Vuex from 'vuex'
 Vue.use(Vuex)

 // import vSelect from 'vue-select'
 // Vue.component('v-select', vSelect)

 import storeData from './store/managerindex'
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
  timerProgressBar: true,
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


 import {routes} from './managerroutes';

 import {filter} from './filter'

 const router = new VueRouter({
     routes, // short for `routes: routes`
     mode:'hash',
 });

 // console.log(router);
const vueBodyClass = new VueBodyClass(routes);
router.beforeEach(function(to, from, next) { 
  Toast.close();
  return vueBodyClass.guard(to, next);
});


const app = new Vue({
    el: '#app',
    router,
    store,
});
