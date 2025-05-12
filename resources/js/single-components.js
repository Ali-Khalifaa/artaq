import './bootstrap';
import { createApp } from 'vue';
import i18n from './lang/admin.js';
import jq from "jquery"
window.$ = window.jQuery = jq;

const app = createApp({});

import 'mapbox-gl/dist/mapbox-gl.css';

import share_booking_google_map_component from './views/admin/taxi/booking/share_booking_google_map_component.vue';

app.component('share-booking-google-map-component', share_booking_google_map_component);
app.use(i18n);


app.mount('#app');



