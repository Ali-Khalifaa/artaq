<template>
    <div :style="{ width, height }" :id="idMap"></div>
</template>

<script>
import MapboxGeocoder from "@mapbox/mapbox-gl-geocoder";
import { ref, onMounted } from "vue";
import {maxLength, minLength, required} from "@vuelidate/validators";

export default {
    name: "getLocation",
    props: {
        idMap: { default: null },
        width: { default: '100% !important' },
        height: { default: '400px !important' },
        icon: { default: '/images/route.png' },
        location: { default: '' },
        type: { default: 'create' },
        dataRow: { default: '' },
        idModel: { default: '' },
    },
    emits: ['getLngLat'],
    setup(props, { emit }) {

        let apiKey = ref(import.meta.env.VITE_MAP_KEY ?? "pk.eyJ1Ijoic21hcnRsZWUiLCJhIjoiY20wczI5NjVsMGFmYTJrc2pzcWszcmVicCJ9.K0kdOBzKlZST5PCgH6thsg");
        const lngLat = ref([]);
        const mark = ref(null);
        const mapLocation = ref(null);
        const currentLocation = ref(null);

        const map = async () => {
            if(props.type == 'create'){
                await navigator.geolocation.getCurrentPosition( (position) => {
                    if(position?.coords.latitude && position?.coords.longitude) {
                        currentLocation.value = [position.coords.latitude, position.coords.longitude];
                    }else {
                        currentLocation.value = [44.55237314810016,  24.686979528178664];
                    }
                });
            }else {
                currentLocation.value = props.dataRow.location.split(', ');
            }
            let locationDefault = currentLocation.value ?? [44.55237314810016,  24.686979528178664];

            mapLocation.value = new mapboxgl.Map({
                container: 'get-location', // Container ID
                center: locationDefault, // Starting position [lng, lat]
                zoom:  10, // Starting zoom
                style: 'mapbox://styles/mapbox/streets-v12',
                language: 'ar',
            });

            mapLocation.value.on('load', () => {
                mapLocation.value.addControl(new mapboxgl.NavigationControl());
                mapLocation.value.setLayoutProperty('country-label', 'text-field', ['get', 'name_ar']);
                // Add a geocoder control
                const geocoder = new MapboxGeocoder({
                    accessToken: apiKey.value,
                    placeholder: "بحث",
                    language: 'ar', // Set the geocoder language to Arabic
                });
                mapLocation.value.addControl(geocoder, 'top-left');
                mapLocation.value.on('click', (e) => {
                    lngLat.value = [e.lngLat.lat,e.lngLat.lng];
                    addMark(e.lngLat,mapLocation.value);
                    emit('getLngLat',`${e.lngLat.lat}, ${e.lngLat.lng}`);
                });

                if(currentLocation.value) {
                    emit('getLngLat',`${currentLocation.value[1]}, ${currentLocation.value[0]}`);
                    lngLat.value = [currentLocation.value[1],currentLocation.value[0]];
                    addMark({ lat: currentLocation.value[1],lng: currentLocation.value[0]},mapLocation.value);
                }

            });

        }

        const addMark = (position, map) => {
            const el = document.createElement('div');
            el.className = 'marker';
            el.style.backgroundImage = `url(${props.icon})`;
            el.style.width = '40px';
            el.style.height = '40px';
            el.style.backgroundSize = 'cover';
            mark.value?.remove()
            mark.value = new mapboxgl.Marker(el).setLngLat([position.lng, position.lat]).addTo(map);

            return mark.value;
        }

        onMounted(async ()=>{
            map();
        });

        setTimeout(async () => {
            if(props.idModel) {
               let myModalEl = document.getElementById(props.idModel)
               myModalEl.addEventListener('show.bs.modal', function (event) {
                setTimeout(() => {
                  const mapContainer = document.getElementById(props.idMap);
                  const isFullWidth = mapContainer.clientWidth === window.innerWidth;

                  if (!isFullWidth) {
                    mapLocation.value.resize();
                  }
                }, 200);
              });
            }else {
                setTimeout(() => {
                  const mapContainer = document.getElementById(props.idMap);
                  const isFullWidth = mapContainer.clientWidth === window.innerWidth;

                  if (!isFullWidth) {
                    mapLocation.value.resize();
                  }
                }, 200);
            }
        }, 150);

        return {};
    }
}
</script>

<style scoped>

/* Style the entire Geocoder control */
.mapboxgl-ctrl-geocoder {
    background-color: #fff; /* Background color */
    border-radius: 4px; /* Rounded corners */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2); /* Subtle shadow */
    display: flex; /* Flexbox for alignment */
    align-items: center; /* Center items vertically */
    padding: 5px; /* Padding around the control */
    width: 400px; /* Width of the control */
}

/* Style for the input element */
.mapboxgl-ctrl-geocoder--input {
    font-family: 'Arial', sans-serif; /* Font family */
    font-size: 16px; /* Font size */
    padding: 10px; /* Padding inside the input */
    border: 1px solid #ccc; /* Border color */
    border-radius: 4px; /* Rounded corners */
    width: 300px; /* Width of the input */
    margin-right: 10px; /* Space between input and button */
    transition: border-color 0.3s ease; /* Transition for border on focus */
}

/* Change border color on focus */
.mapboxgl-ctrl-geocoder--input:focus {
    border-color: #007bff; /* Change border color on focus */
    outline: none; /* Remove default outline */
}


/* Style the suggestions wrapper */
.suggestions-wrapper {
    max-width: 400px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 5px;
    /* position:absolute;
    top:50px */
}

/* Style individual suggestion items */
.suggestions li {
    padding: 10px 15px;
    list-style: none;
    border-bottom: 1px solid #ddd;
    cursor: pointer;
    font-size: 14px;
    color: #333;
}

/* Highlight active suggestion */
.suggestions li.active {
    background-color: #f0f8ff;
    font-weight: bold;
}

/* Hover effect on suggestions */
.suggestions li:hover {
    background-color: #f0f8ff;
}

/* Style the suggestion title and address */
.mapboxgl-ctrl-geocoder--suggestion-title {
    font-size: 16px;
    font-weight: bold;
}

.mapboxgl-ctrl-geocoder--suggestion-address {
    font-size: 14px;
    color: #666;
}
/* Style for the powered by Mapbox link */
.mapboxgl-ctrl-geocoder--powered-by {
    display: none!important; /* Hide the powered by Mapbox text */
    padding: 10px; /* Padding for the link */
    font-size: 12px; /* Smaller font size */
    text-align: center; /* Center the text */
    color: #555; /* Text color */
}

/* Style for the clear button */
.mapboxgl-ctrl-geocoder--button {
    background: none; /* No background */
    border: none; /* Remove border */
    cursor: pointer; /* Pointer cursor */
}

/* Style for icons */
.mapboxgl-ctrl-geocoder--icon {
    fill: #007bff; /* Set icon color */
}
</style>
