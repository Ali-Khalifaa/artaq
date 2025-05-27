<template>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">{{ $t('global.theSettings') }}</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}">{{$t('global.home')}}</router-link></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $t('global.theSettings') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header Close -->
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <label for="subscription_amount" class="form-label">{{$t('global.subscription_amount')}}</label>
                        <input type="number" step="any" class="form-control" id="subscription_amount" :placeholder="$t('global.subscription_amount')"
                            v-model.trim="v$.subscription_amount.$model"
                            :class="{'is-invalid': v$.subscription_amount.$error ||errors[`subscription_amount`],
                            'is-valid':!v$.subscription_amount.$invalid && !errors[`subscription_amount`]}">
                        <div class="invalid-feedback">
                             <span v-if="v$.subscription_amount.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                             <span v-if="v$.subscription_amount.numeric.$invalid">{{$t('validation.ThisFieldIsNumeric')}} <br /></span>
                        </div>
                        <template v-if="errors['subscription_amount']">
                            <error-message v-for="(errorMessage, index) in errors['subscription_amount']" :key="index">
                                {{ errorMessage }}
                            </error-message>
                        </template>
                    </div>

                    <div class="col-md-12 mt-3 mb-3 d-flex justify-content-end">
                        <button type="submit" v-if="!loading" @click.prevent="AddSubmit" class="btn btn-primary">{{ $t('global.Submit') }}</button>
                        <button class="btn btn-primary btn-loader" v-else>
                            <span class="me-2">{{$t('global.Loading')}}</span>
                            <span class="loading"><i class="ri-loader-2-fill fs-16"></i></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {computed, onMounted, reactive, ref, toRefs, watch,onBeforeMount} from "vue";
import {useI18n} from "vue-i18n";
import { minValue, required,numeric} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import adminApi from "../../../api/adminAxios";

export default {
    name: "setting",
    data(){
        return {
            errors:{}
        }
    },
    setup(){
        const errors = ref([]);
        let loading = ref(false);
        const {t} = useI18n({});
        const id = ref(1);

        function defaultData(){
           submitdata.data.subscription_amount = '';
           loading.value = false;
           errors.value = [];
        }
       function resetModal() {
            defaultData();
            setTimeout(async () => {
                adminApi.get(`dashboard/settings/${id.value}`)
                    .then((res) => {
                        loading.value = true;
                        let l = res.data.data;
                        submitdata.data.subscription_amount = l.subscription_amount;

                    })
                    .catch((err) => {
                        console.log(err);
                    })
                    .finally(() => {
                        loading.value = false;
                    })

            }, 50);
        }

        onBeforeMount(() => {
            resetModal();
        });

         //start design
         let submitdata =  reactive({
            data:{
                subscription_amount: '',
            }
        });

        const rules = computed(() => {
            return {
                subscription_amount: {
                    required,
                    numeric,
                    min: minValue(0)
                },

            }
        });

        const v$ = useVuelidate(rules,submitdata.data);

        return {t,id,loading,resetModal,...toRefs(submitdata),v$,errors};

    },
    methods: {
        AddSubmit() {

        this.v$.$validate();
        this.errors = {};

        let formData = new FormData();
            formData.append('subscription_amount', this.data.subscription_amount);
            formData.append('_method','PUT');
        if(!this.v$.$error) {
            this.loading = true;
            adminApi.post(`dashboard/settings/${this.id}`,formData)
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
                });
        }

        }
    }
}
</script>

