<template>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">{{ $t('global.profile') }}</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><router-link
                                :to="{ name: 'dashboard' }">{{ $t('global.home') }}</router-link></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $t('global.profile') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header Close -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <loader v-if="loading" />
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm">

                                <form @submit.prevent="editProfile" class="needs-validation">
                                    <div class="form-row row">
                                        <div class="col-md-6">
                                            <label class="form-label">{{ $t('global.name') }}</label>
                                            <input type="text" class="form-control" v-model="v$.name.$model"
                                                :placeholder="$t('global.name')" :class="{
                                                    'is-invalid': v$.name.$error || errors[`name`],
                                                    'is-valid': !v$.name.$invalid && !errors[`name`]
                                                }">

                                            <div class="invalid-feedback">
                                                <span v-if="v$.name.required.$invalid">{{
                                                    $t('validation.fieldRequired') }}<br />
                                                </span>
                                                <span v-if="v$.name.minLength.$invalid">{{
                                                    $t('validation.TitleIsMustHaveAtLeast') }} {{
                                                        v$.name.minLength.$params.min
                                                    }} {{ $t('validation.Letters') }} <br />
                                                </span>
                                                <span v-if="v$.name.maxLength.$invalid">{{
                                                    $t('validation.TitleIsMustHaveAtMost') }} {{
                                                        v$.name.maxLength.$params.max
                                                    }} {{ $t('validation.Letters') }}
                                                </span>
                                            </div>
                                            <template v-if="errors[`name`]">
                                                <error-message v-for="(errorMessage, index) in errors[`name`]"
                                                    :key="index">
                                                    {{ errorMessage }}
                                                </error-message>
                                            </template>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="validationCustom02">{{ $t('global.email') }}</label>
                                            <input type="email" class="form-control" v-model.trim="v$.email.$model"
                                                id="validationCustom04"
                                                :class="{ 'is-invalid': v$.email.$error || errors[`email`], 'is-valid': !v$.email.$invalid && !errors[`email`] }"
                                                :placeholder="$t('global.email')">
                                            <div class="valid-feedback">{{ $t('global.LooksGood') }}</div>
                                            <div class="invalid-feedback">
                                                <span v-if="v$.email.required.$invalid">{{
                                                    $t('global.EmailIsRequired') }} <br /></span>
                                                <span v-if="v$.email.email.$invalid">{{
                                                    $t('global.ThisFieldMastBeEmail') }} <br /></span>
                                            </div>
                                            <template v-if="errors['email']">
                                                <error-message v-for="(errorMessage, index) in errors['email']"
                                                    :key="index">
                                                    {{ errorMessage }}
                                                </error-message>
                                            </template>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">{{ $t('global.phone') }}</label>
                                            <input type="text" class="form-control" v-model.trim="v$.phone.$model"
                                                id="validationCustom03"
                                                :class="{ 'is-invalid': v$.phone.$error || errors[`phone`], 'is-valid': !v$.phone.$invalid  && !errors[`phone`] }"
                                                :placeholder="$t('global.phone')">
                                            <div class="valid-feedback">{{ $t('global.LooksGood') }}</div>
                                            <div class="invalid-feedback">
                                                <span v-if="v$.phone.required.$invalid">{{
                                                    $t('global.PhoneIsRequired') }} <br /></span>
                                                <span v-if="v$.phone.minLength.$invalid">{{
                                                    $t('global.PhoneIsMustHaveAtLeast') }} {{
                                                        v$.phone.minLength.$params.min
                                                    }} {{ $t('global.Letters') }} <br /></span>
                                                <span v-if="v$.phone.maxLength.$invalid">{{
                                                    $t('global.PhoneIsMustHaveAtMost') }} {{
                                                        v$.phone.maxLength.$params.max
                                                    }} {{ $t('global.Letters') }} </span>
                                            </div>
                                            <template v-if="errors['phone']">
                                                <error-message v-for="(errorMessage, index) in errors['phone']"
                                                    :key="index">
                                                    {{ errorMessage }}
                                                </error-message>
                                            </template>
                                        </div>



                                        <div class="col-md-6">
                                            <label for="validationCustom02">{{ $t('global.password')
                                                }}</label>
                                            <input type="password" v-model.trim="v$.password.$model"
                                                id="validationCustom09"
                                                :class="['form-control', { 'is-invalid': v$.password.$error || errors[`password`], 'is-valid': !v$.password.$invalid && !errors[`password`] }]"
                                                :placeholder="$t('global.password')">
                                            <div class="valid-feedback">{{ $t('global.LooksGood') }}</div>

                                            <div class="invalid-feedback">

                                                <span v-if="v$.password.alphaNum.$invalid">{{
                                                    $t('global.MustBeLettersOrNumbers') }}
                                                    <br /></span>
                                                <span v-if="v$.password.minLength.$invalid">{{
                                                    $t('global.PasswordIsMustHaveAtLeast') }}
                                                    {{
                                                        v$.password.minLength.$params.min
                                                    }} {{ $t('global.Letters') }} <br /></span>
                                                <span v-if="v$.password.maxLength.$invalid">{{
                                                    $t('global.PasswordIsMustHaveAtMost') }}
                                                    {{
                                                        v$.password.maxLength.$params.max
                                                    }} {{ $t('global.Letters') }} </span>
                                            </div>
                                            <template v-if="errors['password']">
                                                <error-message v-for="(errorMessage, index) in errors['password']"
                                                    :key="index">
                                                    {{ errorMessage }}
                                                </error-message>
                                            </template>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="validationCustom02">{{ $t('global.password_confirmation')
                                                }}</label>
                                            <input type="password" v-model.trim="v$.confirmation.$model"
                                                id="validationCustom10"
                                                :class="['form-control', { 'is-invalid': v$.confirmation.$error || errors[`confirmation`], 'is-valid': !v$.confirmation.$invalid && !errors[`confirmation`] }]"
                                                :placeholder="$t('global.password_confirmation')">
                                            <div class="valid-feedback">{{ $t('global.LooksGood') }}</div>

                                            <div class="invalid-feedback">

                                                <span v-if="v$.confirmation.sameAs.$invalid">{{
                                                    $t('global.ConfirmationMustMatchPassword') }}
                                                    <br /></span>
                                            </div>
                                            <template v-if="errors['confirmation']">
                                                <error-message v-for="(errorMessage, index) in errors['confirmation']"
                                                    :key="index">
                                                    {{ errorMessage }}
                                                </error-message>
                                            </template>
                                        </div>
                                        <div class="col-md-12 mb-12 row flex-fill">
                                            <div class="btn btn-outline-primary waves-effect">
                                                <span>
                                                    {{ $t("global.ChooseImages") }}
                                                    <i class="fas fa-cloud-upload-alt ml-3" aria-hidden="true"></i>
                                                </span>
                                                <input name="mediaPackage" type="file" @change="preview"
                                                    id="mediaPackage" accept="image/png,jepg,jpg" />
                                            </div>
                                            <div class="invalid-feedback" v-if="errors.file">{{ errors.file }}</div>

                                            <p class="num-of-files">
                                                {{
                                                    numberOfImage
                                                        ? numberOfImage + $t("global.FilesSelected")
                                                        : $t("global.NoFilesChosen")
                                                }}
                                            </p>
                                            <div class="container-images" v-show="numberOfImage" id="container-images">
                                            </div>
                                            <div class="container-images" v-show="!numberOfImage">
                                                <figure>
                                                    <figcaption>
                                                        <img style="max-width: 150px;max-height: 150px;" :src="`${image}`" />
                                                    </figcaption>
                                                </figure>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary" type="submit">
                                        {{ $t("global.Submit") }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { computed, onBeforeMount, reactive, toRefs, inject, ref } from "vue";
import useVuelidate from "@vuelidate/core";
import {
    required, minLength, maxLength, email, alphaNum, sameAs,
} from "@vuelidate/validators";
import adminApi from "../../../api/adminAxios";
import { useI18n } from "vue-i18n";
import { useStore } from "vuex";
export default {
    name: "editProfile",
    data() {
        return {
            errors: {},
        };
    },
    setup() {
        const emitter = inject("emitter");
        const { t } = useI18n({});
        let admin_id = ref("");
        let id = ref("");
        let loading = ref(false);
        let store = useStore();

        const numberOfImage = ref(0);
        const image = ref("");
        const imageUpload = ref({});
        let preview = (e) => {
            let containerImages = document.querySelector("#container-images");
            if (numberOfImage.value) {
                containerImages.innerHTML = "";
            }

            adminData.data.file = {};
            numberOfImage.value = e.target.files.length;

            adminData.data.file = e.target.files[0];

            let reader = new FileReader();
            let figure = document.createElement("figure");
            let figcap = document.createElement("figcaption");

            figcap.innerText = adminData.data.file.name;
            figure.appendChild(figcap);

            reader.onload = () => {
                let img = document.createElement("img");
                img.setAttribute("src", reader.result);
                img.style.cssText = "max-height: 150px; max-width: 150px;";
                figure.insertBefore(img, figcap);
            };

            containerImages.appendChild(figure);
            reader.readAsDataURL(adminData.data.file);
        };



        onBeforeMount(() => {
            let admin = store.state.authAdmin?.user
            adminData.data.name = admin.name;
            adminData.data.email = admin.email;
            adminData.data.phone = admin.phone;
            image.value = admin.image ?? null;
        });

        let adminData = reactive({
            data: {
                password: "",
                confirmation: "",
                name: "",
                email: "",
                phone: "",
                file: {},
            },
        });

        const rules = computed(() => {
            return {
                name: {
                    minLength: minLength(3),
                    maxLength: maxLength(100),
                    required,
                },
                email: {
                    email,
                    required,
                },
                password: {

                    minLength: minLength(8),
                    maxLength: maxLength(16),
                    alphaNum,
                },
                confirmation: {
                    sameAs: sameAs(adminData.data.password),
                },
                phone: {
                    required,
                    minLength: minLength(8),
                    maxLength: maxLength(20),
                },

            };
        });

        const v$ = useVuelidate(rules, adminData.data);

        return {
            t,
            admin_id,
            id,
            preview,
            imageUpload,
            image,
            numberOfImage,
            loading,
            ...toRefs(adminData),
            v$,
        };
    },
    methods: {
        editProfile() {
            this.v$.$validate();

            if (!this.v$.$error) {
                this.loading = true;
                this.errors = {};
                let formData = new FormData();
                formData.append("name", this.data.name);
                formData.append("email", this.data.email);
                formData.append("phone", this.data.phone);
                formData.append("password", this.data.password);
                formData.append("confirmation", this.data.confirmation);
                formData.append("image", this.data.file);
                formData.append("_method", "PUT");
                adminApi
                    .post(`/dashboard/update-admin-profile`, formData)
                    .then((res) => {
                        this.$store.commit('authAdmin/editUser',res.data.data);

                        Swal.fire({
                            icon: 'success',
                            title: `${this.$t('global.EditSuccessfully')}`,
                            showConfirmButton: false,
                            timer: 1500
                        });

                    })
                    .catch((e) => {
                        if (e.response?.data?.errors) {
                            this.errors = e.response.data.errors;

                        } else {
                            console.log(e)
                        }
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            }
        },
    },
};
</script>

<style scoped>
.coustom-select {
    height: 100px;
}

.card {
    position: relative;
}

.waves-effect {
    position: relative;
    overflow: hidden;
    cursor: pointer;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    width: 200px;
    height: 50px;
    text-align: center;
    line-height: 34px;
    margin: auto;
}

input[type="file"] {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
    padding: 0;
    margin: 0;
    cursor: pointer;
    filter: alpha(opacity=0);
    opacity: 0;
}

.num-of-files {
    text-align: center;
    margin: 20px 0 30px;
}

.container-images {
    width: 90%;
    position: relative;
    margin: auto;
    display: flex;
    justify-content: space-evenly;
    gap: 20px;
    flex-wrap: wrap;
    padding: 10px;
    border-radius: 20px;
    background-color: #f7f7f7;
}

.sec-body {
    border: 3px solid #fcb00c;
    border-radius: 20px;
    padding: 10px;
}

.sec-head {
    background-color: #fcb00c;
    color: #000;
    border-radius: 11px;
    padding: 5px;
    text-align: center;
    margin-bottom: 8px;
    margin-top: 10px;
}

.sec-body:hover .sec-head {
    border: 3px solid #fcb00c;
    padding: 2px;
    border-radius: 11px;
    background-color: #ffff;
}

.sec-head h3 {
    font-weight: 700;
}
</style>
