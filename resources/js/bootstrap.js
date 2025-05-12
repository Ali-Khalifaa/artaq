import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
import mapboxgl from "mapbox-gl";
import 'mapbox-gl/dist/mapbox-gl.css';

mapboxgl.accessToken = import.meta.env.VITE_MAP_KEY ?? "pk.eyJ1Ijoic21hcnRsZWUiLCJhIjoiY20wczI5NjVsMGFmYTJrc2pzcWszcmVicCJ9.K0kdOBzKlZST5PCgH6thsg";// Replace with your Mapbox access token
mapboxgl.setRTLTextPlugin(
    'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.3.0/mapbox-gl-rtl-text.js',
    null,
    true // Lazy load the plugin
);
window.mapboxgl = mapboxgl;
