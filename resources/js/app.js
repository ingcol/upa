require('./bootstrap');

window.Vue = require('vue');
import Vue from 'vue';

import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
Vue.component('v-select', vSelect)
import VuePaginate from 'vue-paginate'
Vue.use(VuePaginate)

import CKEditor from 'ckeditor4-vue';

Vue.use( CKEditor );



Vue.component('filtro-empresa', require('./components/FiltroEmpresaComponent.vue').default);
Vue.component('contacto', require('./components/ContactoComponent.vue').default);
Vue.component('promocion', require('./components/PromocionComponent.vue').default);
Vue.component('nosotros', require('./components/NosotrosComponent.vue').default);
Vue.component('detalle-empresa', require('./components/DetalleEmpresaComponent.vue').default);
Vue.component('nosotros-admin', require('./components/NosotrosAdminComponent.vue').default);
Vue.component('footer-web', require('./components/FooterComponent.vue').default);
Vue.component('publicidad', require('./components/PublicidadComponent.vue').default);
Vue.component('empresa', require('./components/EmpresaComponent.vue').default);
Vue.component('categoria', require('./components/CategoriaAdminComponent.vue').default);
Vue.component('sub-categoria', require('./components/SubCategoriaComponent.vue').default);
Vue.component('departamento', require('./components/DepartamentoComponent.vue').default);
Vue.component('ciudad', require('./components/CiudadComponent.vue').default);

const app = new Vue({
    el: '#app',
});

