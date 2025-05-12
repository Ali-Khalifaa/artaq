<template>
    <div class="col-xxl-7 col-xl-7 col-lg-12">
        <loader v-if="loading" />
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-xxl-6 col-xl-7 col-lg-7 col-md-7 col-sm-8 col-12">
                <div class="p-5">
                    <div class="mb-3">
                        <a href="#">
                            <img src="/assets/images/brand-logos/desktop-logo.png" alt="" class="authentication-brand desktop-logo">
                            <img src="/assets/images/brand-logos/desktop-dark.png" alt="" class="authentication-brand desktop-dark">
                        </a>
                    </div>
                    <form @submit.prevent="adminLogin(loginData.data)">
                    <p class="h5 fw-semibold mb-2">{{$t('auth.signIn')}}</p>
                    <p class="mb-3 text-muted op-7 fw-normal">{{$t('auth.WelcomeBack')}}</p>
                    <div class="row gy-3">
                        <div class="col-xl-12 mt-0">
                            <label for="signin-email" class="form-label text-default">{{$t('label.email')}}</label>
                            <input type="email" class="form-control form-control-lg" v-model="loginData.data.email" id="signin-email" :placeholder="$t('label.email')">
                        </div>
                        <div class="col-xl-12 mb-3">
                            <label for="signin-password" class="form-label text-default d-block">{{$t('label.password')}}</label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg" v-model="loginData.data.password" id="signin-password" :placeholder="$t('label.password')">
                                <button class="btn btn-light" type="button" onclick="createpassword('signin-password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                            </div>
                        </div>
                        <div class="col-xl-12 d-grid mt-2">
                            <button class="btn btn-lg btn-primary" type="submit">{{$t('auth.signIn')}}</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-5 col-xl-5 col-lg-5 d-xl-block d-none px-0">
        <div class="authentication-cover" style="background-color: #111c43 !important; background-image: unset;">
            <div class="aunthentication-cover-content rounded">
                <div class="swiper keyboard-control">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="text-fixed-white text-center p-5 d-flex align-items-center justify-content-center">
                                <div>
                                    <div class="mb-5">
                                        <img src="/assets/images/authentication/logo.png" class="authentication-image" alt="">
                                    </div>
                                    <h6 class="fw-semibold text-fixed-white">{{$t('auth.signIn')}}</h6>
                                    <p class="fw-normal fs-14 op-7">نوصلك لين المكان اللى تبيه</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import login from "./composables/login.js";
    import {useStore} from "vuex";
    import {computed, reactive, toRefs,ref} from "vue";

    const store = useStore();
    const {errors,loading,adminLogin} = login();
    //start design
    let loginData =  reactive({
        data:{
            email:'',
            password:'',
        }
    });

</script>

<style scoped>

</style>
