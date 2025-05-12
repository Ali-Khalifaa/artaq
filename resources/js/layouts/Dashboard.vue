<template>
    <div class="page">

        <!-- Header -->
        <Header />
        <!-- /Header -->

        <!-- Sidebar admin -->
        <template v-if="$store.state.authAdmin.type == 'admin'">
            <SidebarAdmin />
        </template>
        <!-- /Sidebar admin -->

        <!-- Start::app-content -->
        <div class="main-content app-content">
            <router-view v-slot="{ Component }">
                <transition name="scale" mode="out-in">
                    <component :is="Component" />
                </transition>
            </router-view>

        </div>
        <!-- End::app-content -->
        <Footer v-if="!link.includes($route.name)" />
    </div>
</template>

<script>
import Header from "../components/layout/Header.vue";
import SidebarAdmin from "../components/layout/adminSidebar/Sidebar.vue";
import Footer from "../components/layout/Footer.vue";

export default {
    name: "",
    mounted() {
        window.addEventListener('scroll', stickyFn);
        var navbar = document.getElementById("sidebar");
        var sticky = navbar.offsetTop;
        function stickyFn() {
            if (window.scrollY >= 75) {
                navbar.classList.add("sticky-pin")
            } else {
                navbar.classList.remove("sticky-pin");
            }
        }
        window.addEventListener('scroll', stickyFn);
        window.addEventListener('DOMContentLoaded', stickyFn);
    },
    components:{
        Header,
        SidebarAdmin,
        Footer,
    },
    data(){
        return {
            link : ['loginLang','login','Page404','forgetPassword','resetPassword']
        }
    }
}
</script>

<style scoped>

</style>
