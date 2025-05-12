<template>
    <div class="page error-bg" id="particles-js">
        <!-- Start::error-page -->
        <div class="error-page">
            <div class="container">
                <div class="text-center p-5 my-auto">
                    <div class="row align-items-center justify-content-center h-100">
                        <div class="col-xl-7">
                            <p class="error-text mb-sm-0 mb-2">404</p>
                            <p class="fs-18 fw-semibold mb-3">Oops &#128557;,The page you are looking for is not available.</p>
                            <div class="row justify-content-center mb-5">
                                <div class="col-xl-6">
                                    <p class="mb-0 op-7">We are sorry for the inconvenience,The page you are trying to access has been removed or never been existed.</p>
                                </div>
                            </div>
                            <router-link :to="{name:`dashboard${path}`}" class="btn btn-primary"><i class="ri-arrow-left-line align-middle me-1 d-inline-block"></i>BACK TO HOME</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
export default {
    name: "Page404",
    setup(){
        let path = ref('');
        onMounted(() => {
            switch ( JSON.parse(localStorage.getItem('service')) || "General" ) {
                case 'Taxi':
                    path.value = '-taxi';
                    break;
                case 'Admin Restaurants':
                    path.value = '-restaurant';
                    break;
                case 'Water service':
                    path.value = '-water';
                    break;
                case 'Gas':
                    path.value = '-gas';
                    break;
                case 'Store Service':
                    path.value = '-store';
                    break;
                case 'House Cleaning':
                    path.value = '-house';
                    break;
                case 'Fuel Service':
                    path.value = '-fuel';
                    break;
                case 'Printing Service':
                    path.value = '-printing';
                    break;
                case 'Design Service':
                    path.value = '-design';
                    break;
                case 'Hotel and Flight':
                    path.value = '-hotel-flight';
                    break;
                case 'Administrative Service':
                    path.value = '-administrative';
                    break;
                case 'Snapchat Lookalike':
                    path.value = '-snapchat';
                    break;
                default:
                    path= '';
            }
        });
        return { path };
    }
}
</script>

<style scoped>

</style>
