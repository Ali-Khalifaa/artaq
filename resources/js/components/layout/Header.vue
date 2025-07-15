<template>
    <header class="app-header">

        <!-- Start::main-header-container -->
        <div class="main-header-container container-fluid">

            <!-- Start::header-content-left -->
            <div class="header-content-left">

                <!-- Start::header-element -->
                <div class="header-element">
                    <div class="horizontal-logo">
                        <a href="#" class="header-logo">
                            <img src="/assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo">
                            <img src="/assets/images/brand-logos/toggle-logo.png" alt="logo" class="toggle-logo">
                            <img src="/assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark">
                            <img src="/assets/images/brand-logos/toggle-dark.png" alt="logo" class="toggle-dark">
                            <img src="/assets/images/brand-logos/desktop-white.png" alt="logo" class="desktop-white">
                            <img src="/assets/images/brand-logos/toggle-white.png" alt="logo" class="toggle-white">
                        </a>
                    </div>
                </div>
                <!-- End::header-element -->

                <!-- Start::header-element -->
                <div class="header-element">
                    <!-- Start::header-link -->
                    <a aria-label="Hide Sidebar" class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle" data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
                    <!-- End::header-link -->
                </div>
                <!-- End::header-element -->

            </div>
            <!-- End::header-content-left -->

            <!-- Start::header-content-right -->
            <div class="header-content-right">

                <!-- Start::header-element -->
                <lang />
                <!-- End::header-element -->

                <!-- Start::header-element -->
                <div class="header-element header-theme-mode" >
                    <!-- Start::header-link|layout-setting -->
                    <a href="javascript:void(0);" class="header-link layout-setting" @click.prevent="changMode">
                            <span class="light-layout">
                                <!-- Start::header-link-icon -->
                            <i class="bx bx-moon header-link-icon"></i>
                                <!-- End::header-link-icon -->
                            </span>
                        <span class="dark-layout">
                                <!-- Start::header-link-icon -->
                            <i class="bx bx-sun header-link-icon"></i>
                            <!-- End::header-link-icon -->
                            </span>
                    </a>
                    <!-- End::header-link|layout-setting -->
                </div>
                <!-- End::header-element -->

                <!-- Start::header-element -->
                <template  v-if="$store.state.authAdmin.type == 'admin'">
                    <NotificationAdmin />
                </template>
                <!-- End::header-element -->

                <!-- Start::header-element -->
                <div class="header-element header-fullscreen">
                    <!-- Start::header-link -->
                    <a @click.prevent="openFullscreen" href="javascript:void(0);" class="header-link">
                        <i class="bx bx-fullscreen full-screen-open header-link-icon"></i>
                        <i class="bx bx-exit-fullscreen full-screen-close header-link-icon d-none"></i>
                    </a>
                    <!-- End::header-link -->
                </div>
                <!-- End::header-element -->

                <!-- Start::header-element -->
                <div class="header-element">
                    <!-- Start::header-link|dropdown-toggle -->
                    <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <template v-if="$store.state.authAdmin.user">
                                <div class="me-sm-2 me-0">
                                    <img :src="$store.state.authAdmin.user.image ? $store.state.authAdmin.user.image : '/assets/images/faces/9.jpg'" alt="img" width="32" height="32" class="rounded-circle">
                                </div>
                                <div class="d-sm-block d-none">
                                    <p class="fw-semibold mb-0 lh-1">{{$store.state.authAdmin.user?.name}}</p>
                                    <!--                                <span class="op-7 fw-normal d-block fs-11">{{role_name}}</span>-->
                                </div>
                            </template>
                            <template v-else>
                                <div class="me-sm-2 me-0">
                                    <img :src="'/assets/images/faces/9.jpg'" alt="img" width="32" height="32" class="rounded-circle">
                                </div>
                                <div class="d-sm-block d-none">
                                    <p class="fw-semibold mb-0 lh-1"></p>
                                </div>
                            </template>

                        </div>
                    </a>
                    <!-- End::header-link|dropdown-toggle -->
                    <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end" aria-labelledby="mainHeaderProfile">
                        <li><router-link :to="{name: 'profile'}" class="dropdown-item d-flex" ><i class="ti ti-user-circle fs-18 me-2 op-7"></i>{{$t('global.profile')}}</router-link></li>
                        <li><a class="dropdown-item d-flex" href="#" @click="logout"><i class="ti ti-logout fs-18 me-2 op-7"></i>{{$t('global.logout')}}</a></li>
                    </ul>
                </div>
                <!-- End::header-element -->

                <!-- Start::header-element -->
<!--                <div class="header-element">-->
<!--                    &lt;!&ndash; Start::header-link|switcher-icon &ndash;&gt;-->
<!--                    <a href="javascript:void(0);" class="header-link switcher-icon" data-bs-toggle="offcanvas" data-bs-target="#switcher-canvas">-->
<!--                        <i class="bx bx-cog header-link-icon"></i>-->
<!--                    </a>-->
<!--                    &lt;!&ndash; End::header-link|switcher-icon &ndash;&gt;-->
<!--                </div>-->
                <!-- End::header-element -->

            </div>
            <!-- End::header-content-right -->

        </div>
        <!-- End::main-header-container -->

    </header>

</template>

<script>
    import lang from './Lang.vue';
    import NotificationAdmin from './notifications/NotificationAdmin.vue';
    import adminRoute from "../../router/adminRoute";
    import { useI18n } from 'vue-i18n';
    import {useStore} from "vuex";
    import { ref, onMounted } from "vue";

export default {
    setup(){
        const store = useStore();
        const { t } = useI18n();
        async function logout(){

            let type = store.state.authAdmin.type;
            adminRoute.push({name: 'login'});

            store.commit('authAdmin/logoutToken');
        }

        function changMode(){
            let tagHtml = document.querySelector('html');
            let theme_mode = localStorage.getItem("mode") == 'light' ? 'dark' : 'light';
            tagHtml.setAttribute('data-theme-mode', theme_mode);
            tagHtml.setAttribute('data-header-styles', theme_mode);
            tagHtml.setAttribute('data-menu-styles', theme_mode);
            //add data-header-styles="light" to tagHtml
            

            localStorage.setItem('mode',theme_mode);
        }

        /* full screen */
        var elem = document.documentElement;
        function openFullscreen() {
            let open = document.querySelector(".full-screen-open");
            let close = document.querySelector(".full-screen-close");

            if (
                !document.fullscreenElement &&
                !document.webkitFullscreenElement &&
                !document.msFullscreenElement
            ) {
                if (elem.requestFullscreen) {
                    elem.requestFullscreen();
                } else if (elem.webkitRequestFullscreen) {
                    /* Safari */
                    elem.webkitRequestFullscreen();
                } else if (elem.msRequestFullscreen) {
                    /* IE11 */
                    elem.msRequestFullscreen();
                }
                close.classList.add("d-block");
                close.classList.remove("d-none");
                open.classList.add("d-none");
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) {
                    /* Safari */
                    document.webkitExitFullscreen();
                    console.log("working");
                } else if (document.msExitFullscreen) {
                    /* IE11 */
                    document.msExitFullscreen();
                }
                close.classList.remove("d-block");
                open.classList.remove("d-none");
                close.classList.add("d-none");
                open.classList.add("d-block");
            }
        }
        /* full screen */

        return {logout,changMode,openFullscreen};
    },
    components: {
        lang,
        NotificationAdmin,
    }
}
</script>

<style>

</style>
