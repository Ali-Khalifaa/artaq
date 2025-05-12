<template>
    <div class="modal fade" id="role-modal" tabindex="-1" aria-labelledby="roleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-xll modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="roleModalLgLabel">
                        {{ type == 'create' ? $t('global.add') : $t('global.update') }}
                    </h6>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body pt-0">
                                    <div class="card-header mb-4">
                                        <h5 class="card-title">
                                            {{ $t("global.role_name") }}
                                        </h5>
                                    </div>

                                    <div class="col-md-12">
                                        <!-- <label class="form-label">{{ $t('global.role_name') }}</label> -->
                                        <input type="text" class="form-control" v-model="v$.name.$model"
                                            :placeholder="$t('global.name')" :class="{
                                                'is-invalid': v$.name.$error || errors[`name`],
                                                'is-valid': !v$.name.$invalid && !errors[`name`]
                                            }">

                                        <div class="invalid-feedback">
                                            <span v-if="v$.name.required.$invalid">{{ $t('validation.fieldRequired')
                                                }}<br />
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
                                            <error-message v-for="(errorMessage, index) in errors[`name`]" :key="index">
                                                {{ errorMessage }}
                                            </error-message>
                                        </template>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <div class="custom-toggle-switch d-flex align-items-center mb-4">
                                            <input id="toggleswitchPrimary" v-model="data.status" type="checkbox">
                                            <label for="toggleswitchPrimary" class="label-primary"></label><span
                                                class="ms-3">{{
                                                    $t('label.status')
                                                }}</span>
                                        </div>
                                        <template v-if="errors['status']">
                                            <error-message v-for="(errorMessage, index) in errors['status']"
                                                :key="index">
                                                {{ errorMessage }}
                                            </error-message>
                                        </template>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body pt-0">
                                    <div class="card-header mb-4">
                                        <h5 class="card-title">{{ $t('global.permissions') }}</h5>
                                    </div>
                                </div>
                                <template v-for="(role_permission, name) in allPermissions">
                                    <div class="card-body pt-0" :key="role_permission.id"  v-if="role_permission.length > 0">
                                        <div class="card-header mb-4">
                                            <h5 class="card-title">{{ $t('role_and_permissions.' + name) }}</h5>
                                        </div>
                                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                                            <div class="col mb-3 d-flex" v-for="(permission, index) in role_permission"
                                                 :kay="permission.id">
                                                <div class="card flex-fill">
                                                    <div class="card-body p-3 text-center">
                                                        <p class="card-text f-12">{{ $t('role_and_permissions.' + permission.name) }}
                                                        </p>
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="custom-toggle-switch d-flex align-items-center mb-4">
                                                            <input :id="'toggleswitchPrimary'+permission.id" :value="permission.name" v-model="v$.permission.$model" type="checkbox" class="toggle-switch-input">
                                                            <label :for="'toggleswitchPrimary'+permission.id" class="label-primary mt-4 mx-auto"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                .
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
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
import { maxLength, minLength, required } from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import adminApi from "../../../api/adminAxios";
import MultiSelect from 'primevue/multiselect';
export default {
    name: "Role",
    props: {
        type: { default: 'create' },
        dataRow: { default: '' },
    },
    data() {
        return {
            errors: {}
        }
    },
    components: { MultiSelect, },
    setup(props) {

        const { t } = useI18n();

        setTimeout(async () => {
            let myModalEl = document.getElementById('role-modal')
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
        const id = ref(null);
        let allPermissions = ref([]);
        let permissions = ref([]);


        let getPermissions = () => {
            loading.value = true;
            adminApi
                .get(`/dashboard/roles/create`)

                .then((res) => {
                    let l = res.data.data;
                    allPermissions.value = l.permission;
                })
                .catch((err) => {
                    console.log(err.response.data);
                })
                .finally(() => {
                    loading.value = false;
                });
        };

        // emitter.on("get_lang", () => {
        //     getPermissions();
        // });

        onMounted(() => {
            getPermissions();

        });

        function defaultData() {
            submitdata.data.status = true;
            submitdata.data.name = '';
            submitdata.data.permission = [];
            is_disabled.value = false;
            errors.value = [];
        }
        function resetModal() {
            defaultData();
            setTimeout(async () => {
                if (props.type != 'edit') {
                } else {
                    submitdata.data.name = props.dataRow.name;
                    submitdata.data.status = props.dataRow.status == 1;
                    id.value = props.dataRow.id;
                    props.dataRow.permissions.forEach((el) => {
                        submitdata.data.permission.push(el.name);
                    });
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
                name: "",
                permission: []
            }
        });

        // validation image
        const requiredn = ref(false);



        const rules = computed(() => {
            return {
                name: {
                    minLength: minLength(3),
                    maxLength: maxLength(40),
                    required,
                },
                permission: {
                    required,
                },
            }
        });

        const v$ = useVuelidate(rules, submitdata.data);

        return {
            t, id,
            loading, is_disabled,permissions,
            resetModal, resetModalHidden, ...toRefs(submitdata),
            v$, requiredn, errors,allPermissions
        };
    },
    methods: {
        AddSubmit() {

            this.v$.$validate();

            this.errors = {};

            let formData = new FormData();
            this.data.permission.forEach((el) => {
                formData.append(`permission[]`, el);
            });

            formData.append('name', this.data.name);
            formData.append('status', this.data.status ? 1 : 0);
            if (this.image) {
                formData.append('image', this.image);
            }
            if (this.type !== 'edit') {
                if (!this.v$.$error) {
                    this.is_disabled = false;
                    this.loading = true;
                    adminApi.post(`dashboard/roles`, formData)
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
                    this.loading = false;
                    this.is_disabled = false;
                    this.requiredn = true;
                }
            } else if (!this.v$.$error) {
                this.is_disabled = false;
                this.loading = true;
                formData.append('_method', 'PUT');
                adminApi.post(`dashboard/roles/${this.id}`, formData)
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
