import './bootstrap';
import { createApp } from 'vue';
import i18n from './lang/admin.js';
import router  from './router/adminRoute';
import App from "./App.vue";
import store from "./store/admin.js";
import mitt from 'mitt';
import jq from "jquery"
window.$ = window.jQuery = jq;

const emitter = mitt();
const app = createApp(App);

import Loader from './components/Loader.vue';
import ErrorMessage from "./components/ErrorMessage.vue";
import SearchAndFiltersVue from './components/SearchAndFilters.vue';
import { Bootstrap4Pagination } from 'laravel-vue-pagination';
import GetLocation from './components/general/GetLocation.vue';
import 'mapbox-gl/dist/mapbox-gl.css';


import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';

import Select from 'primevue/select';

app.provide('emitter', emitter);
app.component('loader', Loader);
app.component("error-message", ErrorMessage);
app.component('Pagination', Bootstrap4Pagination);
app.component('get-location', GetLocation);
app.component('search-and-filters', SearchAndFiltersVue)
app.component('Select', Select)


app.use(PrimeVue, {
    theme: {
        preset: Aura
    },

});
app.use(i18n).use(router).use(store).mount('#app');



