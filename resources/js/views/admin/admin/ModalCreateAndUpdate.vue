<template>
    <div class="modal fade" id="admin-modal" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="adminModalLabel">
                        {{ type == 'create' ? $t('global.add') : $t('global.update') }}
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">{{ $t('global.name') }}</label>
                            <input type="text" class="form-control" v-model="v$.name.$model"
                                :placeholder="$t('global.name')" :class="{
                                    'is-invalid': v$.name.$error || errors[`name`],
                                    'is-valid': !v$.name.$invalid && !errors[`name`]
                                }">

                            <div class="invalid-feedback">
                                <span v-if="v$.name.required.$invalid">{{ $t('validation.fieldRequired') }}<br />
                                </span>
                                <span v-if="v$.name.minLength.$invalid">{{ $t('validation.TitleIsMustHaveAtLeast') }} {{
                                    v$.name.minLength.$params.min
                                    }} {{ $t('validation.Letters') }} <br />
                                </span>
                                <span v-if="v$.name.maxLength.$invalid">{{ $t('validation.TitleIsMustHaveAtMost') }} {{
                                    v$.name.maxLength.$params.max
                                    }} {{ $t('validation.Letters') }}
                                </span>
                            </div>
                            <template v-if="errors[`name`]">
                                <error-message v-for="(errorMessage, index) in errors[`name`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom02">{{ $t('global.email') }}</label>
                            <input type="email" class="form-control" v-model.trim="v$.email.$model"
                                id="validationCustom04"
                                :class="{ 'is-invalid': v$.email.$error || errors[`email`], 'is-valid' : !v$.email.$invalid && !errors[`email`]}"
                                :placeholder="$t('global.email')">
                            <div class="valid-feedback">{{ $t('global.LooksGood') }}</div>
                            <div class="invalid-feedback">
                                <span v-if="v$.email.required.$invalid">{{
                                    $t('global.EmailIsRequired') }} <br /></span>
                                <span v-if="v$.email.email.$invalid">{{
                                    $t('global.ThisFieldMastBeEmail') }} <br /></span>
                            </div>
                            <template v-if="errors['email']">
                                <error-message v-for="(errorMessage, index) in errors['email']" :key="index">
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
                                <error-message v-for="(errorMessage, index) in errors['phone']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ $t('global.choose_role') }}</label>

                            <select v-model="data.role_name"
                                :class="['form-select', { 'is-invalid': v$.role_name.$error || errors[`role_name`], 'is-valid': !v$.role_name.$invalid && !errors[`role_name`]}]">
                                <option value="" disabled selected>{{ $t('global.choose_role') }}</option>
                                <option v-for="role in mainRole" :kay="role.id"
                                    :value="role.id">{{ role.name }}
                                </option>
                            </select>
                            <div class="valid-feedback">{{ $t('global.LooksGood') }}</div>
                            <div class="invalid-feedback">
                                <span v-if="v$.role_name.required.$invalid">{{
                                    $t('global.ThisFieldIsRequired') }}<br />
                                </span>
                            </div>
                            <template v-if="errors['role_name']">
                                <error-message v-for="(errorMessage, index) in errors['role_name']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>



                        <div class="col-md-6">
                            <label for="validationCustom02">{{ $t('global.password')
                                }}</label>
                            <input type="password" v-model.trim="v$.password.$model" id="validationCustom09"
                                :class="['form-control', { 'is-invalid': v$.password.$error || errors[`password`], 'is-valid': !v$.password.$invalid&& !errors[`password`] }]"
                                :placeholder="$t('global.password')">
                            <div class="valid-feedback">{{ $t('global.LooksGood') }}</div>

                            <div class="invalid-feedback">
                                <span v-if="v$.password.required.$invalid">{{ $t('global.PasswordIsRequired') }}<br />
                                </span>
                                <span v-if="v$.password.alphaNum.$invalid">{{ $t('global.MustBeLettersOrNumbers') }}
                                    <br /></span>
                                <span v-if="v$.password.minLength.$invalid">{{ $t('global.PasswordIsMustHaveAtLeast') }}
                                    {{
                                        v$.password.minLength.$params.min
                                    }} {{ $t('global.Letters') }} <br /></span>
                                <span v-if="v$.password.maxLength.$invalid">{{ $t('global.PasswordIsMustHaveAtMost') }}
                                    {{
                                        v$.password.maxLength.$params.max
                                    }} {{ $t('global.Letters') }} </span>
                            </div>
                            <template v-if="errors['password']">
                                <error-message v-for="(errorMessage, index) in errors['password']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6">
                            <label for="validationCustom02">{{ $t('global.password_confirmation')
                                }}</label>
                            <input type="password" v-model.trim="v$.confirmation.$model" id="validationCustom10"
                                :class="['form-control', { 'is-invalid': v$.confirmation.$error || errors[`confirmation`], 'is-valid': !v$.confirmation.$invalid && !errors[`confirmation`] }]"
                                :placeholder="$t('global.password_confirmation')">
                            <div class="valid-feedback">{{ $t('global.LooksGood') }}</div>

                            <div class="invalid-feedback">
                                <span v-if="v$.confirmation.required.$invalid">{{ $t('global.ConfirmIsRequired') }}<br />
                                </span>
                                <span v-if="v$.confirmation.sameAs.$invalid">{{
                                    $t('global.ConfirmationMustMatchPassword') }}
                                    <br /></span>
                            </div>
                            <template v-if="errors['confirmation']">
                                <error-message v-for="(errorMessage, index) in errors['confirmation']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6 mt-4">
                            <div class="custom-toggle-switch d-flex align-items-center mb-4">
                                <input id="toggleswitchPrimary" v-model="data.status" type="checkbox">
                                <label for="toggleswitchPrimary" class="label-primary"></label><span class="ms-3">{{
                                    $t('global.status')
                                }}</span>
                            </div>
                            <template v-if="errors['status']">
                                <error-message v-for="(errorMessage, index) in errors['status']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-12 mt-3 row flex-fill">
                            <div class="btn btn-outline-light waves-effect" style="width: 90%; height:90%">

                                <span v-if="type != 'edit' && !numberOfImage" style="margin-top:30%;">
                                    {{ $t('global.ChooseImages') }}
                                    <br><i class="bi bi-cloud-upload fs-40"></i>
                                    <i class="fas fa-cloud-upload-alt ml-3" aria-hidden="true"></i>
                                </span>

                                <div id="container-images" v-show="image && numberOfImage"></div>

                                <div v-if="type == 'edit'" v-show="!numberOfImage">
                                    <figure>
                                        <figcaption>
                                            <img class="img-fluid rounded" :src="`${imageUpload}`">
                                        </figcaption>
                                    </figure>
                                </div>
                                <input name="mediaPackage" type="file" @change="preview" id="mediaPackage"
                                    accept="image/*">

                                <template v-if="errors['file']">
                                    <error-message v-for="(errorMessage, index) in errors['file']" :key="index">
                                        {{ errorMessage }}
                                    </error-message>
                                </template>
                                <template class="text-danger text-center" v-if="requiredn">
                                    <error-message>{{ $t('global.ImagesIsMustHaveAtLeast1Photos')
                                        }}<br /></error-message>
                                </template>
                            </div>
                            <p class="num-of-files">{{ numberOfImage ? numberOfImage + $t('global.FilesSelected') :
                                $t('global.NoFilesChosen') }}
                            </p>

                            <template v-if="errors[`image`]">
                                <error-message v-for="(errorMessage, index) in errors[`image`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button v-if="type != 'edit'" :disabled="!is_disabled" @click.prevent="resetModal" type="button"
                        class="btn btn-secondary">{{ $t('global.AddNewRecord') }}</button>
                    <template v-if="!is_disabled">
                        <button type="submit" v-if="!loading" @click.prevent="AddSubmit" class="btn btn-primary">{{
                            $t('global.Submit') }}</button>

                        <button class="btn btn-primary btn-loader" v-else>
                            <span class="me-2">{{ $t('global.Loading') }}</span>
                            <span class="loading"><i class="ri-loader-2-fill fs-16"></i></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { computed, onMounted, reactive, ref, toRefs, watch, nextTick } from "vue";
import { useI18n } from "vue-i18n";
import { maxLength, minLength, required, email, sameAs, alphaNum, requiredIf } from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import adminApi from "../../../api/adminAxios";

export default {
    name: "Admin",
    props: {
        type: { default: 'create' },
        dataRow: { default: '' },
    },
    data() {
        return {
            errors: {}
        }
    },
    setup(props) {
        setTimeout(async () => {
            let myModalEl = document.getElementById('admin-modal')
            myModalEl.addEventListener('show.bs.modal', function (event) {
                resetModal();
            })
            myModalEl.addEventListener('hidden.bs.modal', function (event) {
                resetModalHidden();
            })
        }, 150);
        const errors = ref([]);
        let loading = ref(false);
        let is_disabled = ref(false);
        const { t } = useI18n({});
        const id = ref(null);

        let mainRole = ref([]);


        let getMainRoleViews = () => {
            loading.value = true;

            adminApi.get(`/dashboard/all_roles`)
                .then((res) => {
                    mainRole.value = res.data.data;
                })
                .catch((err) => {
                    console.log(err.response.data);
                })
                .finally(() => {
                    loading.value = false;
                })
        }

        onMounted(() => {
            getMainRoleViews();
        });

        function defaultData() {
            submitdata.data.status = true;
            submitdata.data.name = '';
            submitdata.data.phone = '';
            submitdata.data.email = '';
            submitdata.data.role_name = '';
            submitdata.data.password = '';
            submitdata.data.confirmation = '';
            imageUpload.value = '';
            is_disabled.value = false;
            image.value = null
            errors.value = [];
            empty();
        }
        function resetModal() {
            defaultData();
            setTimeout(async () => {
                if (props.type != 'edit') {
                } else {
                    id.value = props.dataRow.id;
                    submitdata.data.name = props.dataRow.name;
                    submitdata.data.phone = props.dataRow.phone;
                    submitdata.data.email = props.dataRow.email;
                    submitdata.data.role_name = props.dataRow.role_name;
                    submitdata.data.status = props.dataRow.status == 1;
                    imageUpload.value = props.dataRow.image;
                }
            }, 50);
        }
        function resetModalHidden() {
            defaultData();
            nextTick(() => { v$.value.$reset() });
        }

        //start design
        let submitdata = reactive({
            data: {
                status: true,
                name: '',
                email: '',
                password: '',
                confirmation: '',
                phone: '',
                role_name: '',
                image: {}
            }
        });

        const numberOfImage = ref(0);
        const image = ref({});
        const imageUpload = ref({});

        let empty = () => {
            numberOfImage.value = 0;
            let clearInput = document.querySelector('#mediaPackage').value = '';
            requiredn.value = false;
        }

        let preview = (e) => {

            let containerImages = document.querySelector('#container-images');
            containerImages.innerHTML = '';
            image.value = {};

            numberOfImage.value = e.target.files.length;

            image.value = e.target.files[0];

            let reader = new FileReader();
            let figure = document.createElement('figure');
            let figcap = document.createElement('figcaption');

            figcap.innerText = image.value.name;
            figure.appendChild(figcap);

            reader.onload = () => {
                let img = document.createElement('img');
                img.setAttribute('src', reader.result);
                img.classList.add('img-fluid', 'rounded');
                figure.insertBefore(img, figcap);
            }

            containerImages.appendChild(figure);
            reader.readAsDataURL(image.value);

        }

        // validation image
        const requiredn = ref(false);

        watch(numberOfImage, (count, prevCount) => {
            if (!count) {
                requiredn.value = true;
            } else {
                requiredn.value = false;
            }
        });

        const rules = computed(() => {
            return {
                name: {
                    minLength: minLength(3),
                    maxLength: maxLength(100),
                    required
                },
                email: {
                    email,
                    required
                },
                password: {
                    required : requiredIf(function(model){return props.type =='create';}),
                    minLength: minLength(8),
                    maxLength: maxLength(16),
                    alphaNum
                }
                ,
                confirmation: {
                    required : requiredIf(function(model){return props.type =='create';}),
                    sameAs: sameAs(submitdata.data.password)
                },
                phone: {
                    required,
                    minLength: minLength(8),
                    maxLength: maxLength(20)
                },

                role_name: {
                    required
                },

            }
        });

        const v$ = useVuelidate(rules, submitdata.data);

        return {
            t, id,
            loading, is_disabled, mainRole,
            resetModal, empty, preview, resetModalHidden,
            imageUpload, image, ...toRefs(submitdata),
            v$, numberOfImage, requiredn, errors
        };
    },
    methods: {
        AddSubmit() {

            this.v$.$validate();
            this.errors = {};

            let formData = new FormData();

            formData.append('status', this.data.status ? 1 : 0);
            formData.append('name', this.data.name ?? '');
            formData.append('phone', this.data.phone ?? '');
            formData.append('email', this.data.email ?? '');
            formData.append('password', this.data.password ?? '');
            formData.append('confirmation', this.data.confirmation ?? '');
            formData.append('role_name', this.data.role_name ?? '');
            if (this.image) {
                formData.append('image', this.image);
            }
            if (this.type !== 'edit') {
                if (!this.v$.$error && this.numberOfImage) {
                    this.is_disabled = false;
                    this.loading = true;
                    adminApi.post(`dashboard/admins`, formData)
                        .then((res) => {
                            Swal.fire({
                                icon: 'success',
                                title: `${this.t('global.AddedSuccessfully')}`,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            this.resetModalHidden();
                        })
                        .catch((err) => {
                            this.errors = err.response.data.errors;
                        })
                        .finally(() => {
                            if (Object.keys(this.errors).length === 0) {
                                this.loading = false;
                                this.is_disabled = true;
                                this.$emit("created");
                            } else {
                                this.loading = false;
                                this.is_disabled = false;
                            }
                        });
                } else {
                    if (!this.numberOfImage) {
                        this.loading = false;
                        this.is_disabled = false;
                        this.requiredn = true;
                    }
                }
            } else if (!this.v$.$error) {
                this.is_disabled = false;
                this.loading = true;
                formData.append('_method', 'PUT');
                adminApi.post(`dashboard/admins/${this.id}`, formData)
                    .then((res) => {
                        Swal.fire({
                            icon: 'success',
                            title: `${this.t('global.EditSuccessfully')}`,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    })
                    .catch((err) => {
                        this.errors = err.response.data.errors;

                    })
                    .finally(() => {
                        this.loading = false;
                        this.$emit("created");
                    });
            }

        }
    }
}
</script>

<style scoped>
.coustom-select {
    height: 100px;
}

.card {
    position: relative;
}

.package-feature ul li:first-child {
    margin-top: 10px;
}

.package-feature ul li::before {
    content: "\f00c";
    font-family: "Font Awesome 5 Free";
    font-weight: 600;
    color: #4B9F18;
    left: 0;
    position: absolute;
    top: 0;
}

.package-feature ul li:last-child {
    margin-bottom: 10px;
}

.ml-3 {
    margin-left: 1.5rem;
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
</style>
