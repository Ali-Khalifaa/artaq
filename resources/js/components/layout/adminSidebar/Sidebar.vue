<template>

    <!-- Start::app-sidebar -->
    <aside class="app-sidebar sticky" id="sidebar">

        <!-- Start::main-sidebar-header -->
        <div class="main-sidebar-header">
            <router-link :to="{name:`dashboard${path}`}" class="header-logo">
                <!-- <img src="/assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo">
                <img src="/assets/images/brand-logos/toggle-logo.png" alt="logo" class="toggle-logo">
                <img src="/assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark">
                <img src="/assets/images/brand-logos/toggle-dark.png" alt="logo" class="toggle-dark">
                <img src="/assets/images/brand-logos/desktop-white.png" alt="logo" class="desktop-white">
                <img src="/assets/images/brand-logos/toggle-white.png" alt="logo" class="toggle-white"> -->

                <img src="/assets/images/brand-logos/center.png" alt="logo" class="desktop-logo">
                <img src="/assets/images/brand-logos/center.png" alt="logo" class="toggle-logo">
                <img src="/assets/images/brand-logos/center.png" alt="logo" class="desktop-dark">
                <img src="/assets/images/brand-logos/center.png" alt="logo" class="toggle-dark">
                <img src="/assets/images/brand-logos/center.png" alt="logo" class="desktop-white">
                <img src="/assets/images/brand-logos/center.png" alt="logo" class="toggle-white">
            </router-link>
        </div>
        <!-- End::main-sidebar-header -->

        <!-- Start::main-sidebar -->
        <div class="main-sidebar" id="sidebar-scroll">

            <!-- Start::nav -->
            <nav class="main-menu-container nav nav-pills flex-column sub-open">
                <div class="slide-left" id="slide-left">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg>
                </div>
                <ul class="main-menu">

                    <!-- Start::Dashboard -->
                    <li class="slide">
                        <router-link :to="{name:'dashboard'}" class="side-menu__item">
                            <i class="bx bx-home side-menu__icon"></i>
                            <span class="side-menu__label">{{$t('global.home')}}</span>
                        </router-link>
                    </li>
                    <!-- End::Dashboard -->

                     <!-- Start::permissions -->
                    <li class="slide has-sub" v-show="(permission.includes('admin read') || permission.includes('role read'))"
                        :class="[$route.name == 'admin' || $route.name == 'role'  ? 'active open': '']"
                    >
                        <a href="javascript:void(0);" class="side-menu__item"
                        :class="[$route.name == 'admin' || $route.name == 'role'  ? 'active': '']"
                        >
                            <i class="bx bx-user-plus side-menu__icon"></i>
                            <span class="side-menu__label">{{$t('global.permissions')}}</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1"
                        >
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">{{$t('global.permissions')}}</a>
                            </li>
                            <li class="slide" v-if="permission.includes('admin read')">
                                <router-link :to="{name:'admin'}" class="side-menu__item">{{$t('global.employees')}}</router-link>
                            </li>
                            <li class="slide" v-if="permission.includes('role read')">
                                <router-link :to="{name:'role'}" class="side-menu__item">{{$t('global.roleAndPermissions')}}</router-link>
                            </li>
                        </ul>
                    </li>
                    <!-- End::permissions -->


                    <li class="slide" v-show="permission.includes('banner read')">
                        <router-link :to="{name:'banner'}" class="side-menu__item">
                            <i class="bx bx-image side-menu__icon"></i>
                            <span class="side-menu__label">{{$t('global.banners')}}</span>
                        </router-link>
                    </li>

                    <li class="slide" v-show="permission.includes('country read')">
                        <router-link :to="{name:'country'}" class="side-menu__item">
                            <i class="bx bx-globe side-menu__icon"></i>
                            <span class="side-menu__label">{{$t('global.countries')}}</span>
                        </router-link>
                    </li>

                    <li class="slide" v-show="permission.includes('city read')">
                        <router-link :to="{name:'city'}" class="side-menu__item">
                            <i class="bx bx-buildings side-menu__icon"></i>
                            <span class="side-menu__label">{{$t('global.cities')}}</span>
                        </router-link>
                    </li>

                    <li class="slide" v-show="permission.includes('nationality read')">
                        <router-link :to="{name:'nationality'}" class="side-menu__item">
                            <i class="bx bx-flag side-menu__icon"></i>
                            <span class="side-menu__label">{{$t('global.nationalities')}}</span>
                        </router-link>
                    </li>

                    <li class="slide" v-show="permission.includes('student read')">
                        <router-link :to="{name:'student'}" class="side-menu__item">
                            <i class="bx bx-user side-menu__icon"></i>
                            <span class="side-menu__label">{{$t('global.students')}}</span>
                        </router-link>
                    </li>

                    <li class="slide" v-show="permission.includes('circle type read')">
                        <router-link :to="{name:'circleTypes'}" class="side-menu__item">
                            <i class="bx bx-shape-circle side-menu__icon"></i>
                            <span class="side-menu__label">{{$t('global.circleTypes')}}</span>
                        </router-link>
                    </li>

                    <li class="slide" v-show="permission.includes('circle read')">
                        <router-link :to="{name:'circles'}" class="side-menu__item">
                            <i class="bx bx-circle side-menu__icon"></i>
                            <span class="side-menu__label">{{$t('global.circles')}}</span>
                        </router-link>
                    </li>

                    <li class="slide" v-show="permission.includes('quran read')">
                        <router-link :to="{name:'quran'}" class="side-menu__item">
                            <i class="bx bx-book-open side-menu__icon"></i>
                            <span class="side-menu__label">{{$t('global.quran')}}</span>
                        </router-link>
                    </li>

                    <li class="slide" v-show="permission.includes('join us read')">
                        <router-link :to="{name:'joinUs'}" class="side-menu__item">
                            <i class="bx bx-user side-menu__icon"></i>
                            <span class="side-menu__label">{{$t('global.joinUs')}}</span>
                        </router-link>
                    </li>

                    <li class="slide" v-show="permission.includes('database backup read')">
                        <router-link :to="{name:'backup'}" class="side-menu__item">
                            <i class="bx bx-cloud-download side-menu__icon" aria-hidden="true"></i>
                            <span class="side-menu__label">{{$t('global.databaseBackup')}}</span>
                        </router-link>
                    </li>
                    <li class="slide" v-show="permission.includes('memorization amount read')">
                        <router-link :to="{name:'memorizationAmount'}" class="side-menu__item">
                            <i class="bx bx-book-bookmark side-menu__icon" aria-hidden="true"></i>
                            <span class="side-menu__label">{{$t('global.memorizationAmount')}}</span>
                        </router-link>
                    </li>
                    <li class="slide" v-show="permission.includes('memorization type read')">
                        <router-link :to="{name:'memorizationType'}" class="side-menu__item">
                            <i class="bx bx-book-bookmark side-menu__icon" aria-hidden="true"></i>
                            <span class="side-menu__label">{{$t('global.memorizationType')}}</span>
                        </router-link>
                    </li>

                    <li class="slide" v-show="permission.includes('setting read')">
                        <router-link :to="{name:'setting'}" class="side-menu__item">
                            <i class="bx bx-cog side-menu__icon" aria-hidden="true"></i>
                            <span class="side-menu__label">{{$t('global.theSettings')}}</span>
                        </router-link>
                    </li>

                    <li class="slide" v-show="permission.includes('level read')">
                        <router-link :to="{name:'level'}" class="side-menu__item">
                            <i class="bx bx-layer side-menu__icon" aria-hidden="true"></i>
                            <span class="side-menu__label">{{$t('global.levels')}}</span>
                        </router-link>
                    </li>

                    <li class="slide" v-show="permission.includes('level task read')">
                        <router-link :to="{name:'levelTask'}" class="side-menu__item">
                            <i class="bx bx-task side-menu__icon" aria-hidden="true"></i>
                            <span class="side-menu__label">{{$t('global.levelTask')}}</span>
                        </router-link>
                    </li>

                    <li class="slide" v-show="permission.includes('track read')">
                        <router-link :to="{name:'track'}" class="side-menu__item">
                            <i class="bx bx-git-branch side-menu__icon" aria-hidden="true"></i>
                            <span class="side-menu__label">{{$t('global.tracks')}}</span>
                        </router-link>
                    </li>

                    <li class="slide has-sub" v-show="(permission.includes('digital badge read') || permission.includes('teacher badge read'))"
                        :class="[$route.name == 'digitalBadge' || $route.name == 'teacherBadge'  ? 'active open': '']"
                    >
                        <a href="javascript:void(0);" class="side-menu__item"
                        :class="[$route.name == 'digitalBadge' || $route.name == 'teacherBadge'  ? 'active': '']"
                        >
                            <i class="bx bx-medal side-menu__icon"></i>
                            <span class="side-menu__label">{{$t('global.Badges')}}</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1"
                        >
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">{{$t('global.Badges')}}</a>
                            </li>
                            <li class="slide" v-if="permission.includes('digital badge read')">
                                <router-link :to="{name:'digitalBadge'}" class="side-menu__item">{{$t('global.digitalBadges')}}</router-link>
                            </li>
                            <li class="slide" v-if="permission.includes('teacher badge read')">
                                <router-link :to="{name:'teacherBadge'}" class="side-menu__item">{{$t('global.teacherBadges')}}</router-link>
                            </li>
                        </ul>
                    </li>

                </ul>
                <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
            </nav>
            <!-- End::nav -->

        </div>
        <!-- End::main-sidebar -->

    </aside>
    <!-- End::app-sidebar -->
</template>

<script setup>
import {onMounted, computed, defineComponent, ref} from "vue";
import {useStore} from 'vuex';
import defaultrmenu from '../../../helper/defaultrmenu';


let store = useStore();
let path = ref('');
let { menu } = defaultrmenu();

let permission = computed(() => store.getters['authAdmin/permission']);


onMounted(()=>{
    menu();
});

</script>

<style>

</style>
