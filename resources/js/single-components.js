import './bootstrap';
import { createApp } from 'vue';
import i18n from './lang/admin.js';
import jq from "jquery"
window.$ = window.jQuery = jq;

const app = createApp({});

import 'mapbox-gl/dist/mapbox-gl.css';


app.use(i18n);


app.mount('#app');



