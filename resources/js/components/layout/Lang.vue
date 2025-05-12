<template>
    <div class="header-element country-selector">
        <!-- Start::header-link|dropdown-toggle -->
        <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-auto-close="outside" data-bs-toggle="dropdown">
            <img :src="`/assets/images/flags/sau_Flag.jpg`" alt="img" class="rounded-circle header-link-icon">
        </a>
        <!-- End::header-link|dropdown-toggle -->
        <ul class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
            <li>
                <a class="dropdown-item d-flex align-items-center" id="switcher-rtl" href="javascript:void(0);">
                    <span class="avatar avatar-xs lh-1 me-2">
                        <img src="/assets/images/flags/sau_Flag.jpg" alt="img" >
                    </span>
                    {{$t('global.arabic')}}
                </a>
            </li>
        </ul>
    </div>

<!--    v-if="locale != this.$i18n.locale"-->
</template>

<script>

export default {
    setup(){
    },
    data() {
        return {
            locales: ['ar']
        }
    }
}
</script>

<style scoped>
.lang{
    position: relative;
}

.user-menu .dropdown-menu {
    min-width: 90px;
}

.lang::before {
    position: absolute;
    content: '';
    width: 26px;
    height: 26px;
    top: 29%;
    left: 20%;
    border: 1px solid #999eb6;
    border-radius: 50%;
}

.small {
    height: 22px;
    width: 33px;
    margin-left: 10px;
}

</style>


