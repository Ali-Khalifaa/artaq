<template>
    <div class="modal fade" id="add-admin-modal" tabindex="-1"
         aria-labelledby="exampleModalLgLabel" aria-hidden="true" >
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLgLabel">
                        {{$t('role_and_permissions.add time to exam')}}
                    </h6>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 ">
                            <label class="form-label">{{ $t('global.selectAdmin') }}</label>

                            <Select v-model="data.admin_id" :filterFields="['id','name','phone']" :options="admins" filter
                                    :invalid="v$.admin_id.$error || errors[`admin_id`]"
                                        optionLabel="name" optionValue="id"
                                    :class="['w-full w-100', { 'is-invalid': v$.admin_id.$error || errors[`admin_id`], 'is-valid': !v$.admin_id.$invalid && !errors[`admin_id`] }]">

                            </Select>
                            <div class="invalid-feedback">
                                <span v-if="v$.admin_id.required.$invalid">{{
                                        $t('global.ThisFieldIsRequired') }}<br />
                                </span>
                            </div>
                            <template v-if="errors['admin_id']">
                                <error-message v-for="(errorMessage, index) in errors['admin_id']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">{{$t('global.examTime')}}</label>
                            <input type="text" id="datetime" class="form-control custom-time-picker" v-model.trim="v$.date_time.$model"
                                :class="{'is-invalid': v$.date_time.$error ||errors[`date_time`],
                                'is-valid':!v$.date_time.$invalid && !errors[`date_time`]}">
                            <div class="invalid-feedback">
                                <span v-if="v$.date_time.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                            </div>
                             <template v-if="errors['date_time']">
                                <error-message v-for="(errorMessage, index) in errors['date_time']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>
                        <div class="col-md-12 mt-3">
                            <label class="form-label">{{$t('global.examLink')}}</label>
                            <input type="text" class="form-control" v-model.trim="v$.exam_link.$model"
                                :class="{'is-invalid': v$.exam_link.$error ||errors[`exam_link`],
                                'is-valid':!v$.exam_link.$invalid && !errors[`exam_link`]}">
                            <div class="invalid-feedback">
                                <span v-if="v$.exam_link.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                            </div>
                             <template v-if="errors['exam_link']">
                                <error-message v-for="(errorMessage, index) in errors['exam_link']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <template v-if="!is_disabled">
                        <button type="submit" v-if="!loading" @click.prevent="AddSubmit" class="btn btn-primary">{{ $t('global.Submit') }}</button>

                        <button class="btn btn-primary btn-loader" v-else>
                            <span class="me-2">{{$t('global.Loading')}}</span>
                            <span class="loading"><i class="ri-loader-2-fill fs-16"></i></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {computed, onMounted, reactive, ref, toRefs, watch,nextTick} from "vue";
import {useI18n} from "vue-i18n";
import {maxLength, minLength, required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import adminApi from "../../../api/adminAxios";

export default {
    name: "AddAdmin",
    props: {
        dataRow: {default: ''},
    },
    data(){
        return {
            errors:{}
        }
    },
    setup(props){
        setTimeout(async () => {
            let myModalEl = document.getElementById('add-admin-modal')
            myModalEl.addEventListener('show.bs.modal', function (event) {
                resetModal();
            })
            myModalEl.addEventListener('hidden.bs.modal', function (event) {
                resetModalHidden();
            })
        }, 150);
        const errors = ref([]);
        const admins = ref([]);
        let loading = ref(false);
        let is_disabled = ref(false);
        const {t} = useI18n({});
        const id = ref(null);

        onMounted(()=>{

             flatpickr("#datetime", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
            });
        });

       function defaultData(){
           submitdata.data.admin_id = '';
           submitdata.data.date_time = '';
           submitdata.data.exam_link = '';
           is_disabled.value = false;
           loading.value = false;
           errors.value = [];
        }
         let getAdmins = () => {
            loading.value = true;

            adminApi.get(`dashboard/admins-dropdown`)
                .then((res) => {
                    let l = res.data.data;
                    admins.value = l;
                })
                .catch((err) => {
                    console.log(err.response.data);
                })
                .finally(() => {
                    loading.value = false;
                })
        }
       function resetModal() {
            defaultData();
            setTimeout(async () => {
                getAdmins();
                id.value = props.dataRow.id;
                submitdata.data.admin_id = props.dataRow.admin_id;
                submitdata.data.date_time = props.dataRow.date_time;
                submitdata.data.exam_link = props.dataRow.exam_link;
            }, 50);
        }
       function resetModalHidden()
        {
            defaultData();
            nextTick(() => { v$.value.$reset() });
        }

        //start design
        let submitdata =  reactive({
            data:{
                admin_id: '',
                date_time: '',
                exam_link: '',
            }
        });

        const rules = computed(() => {
            return {
                admin_id: {required},
                date_time: {required},
                exam_link: {required},
            }
        });

        const v$ = useVuelidate(rules,submitdata.data);

        return {t,id,loading,is_disabled,resetModal,admins,resetModalHidden,...toRefs(submitdata),v$,errors};
    },
    methods: {
        AddSubmit() {

        this.v$.$validate();
        this.errors = {};

        let formData = new FormData();
        formData.append('admin_id', this.data.admin_id);
        formData.append('date_time', this.data.date_time);
        formData.append('link', this.data.exam_link);

            this.is_disabled = false;
            this.loading = true;
            formData.append('_method','PUT');
            adminApi.post(`dashboard/add-time-to-exam/${this.id}`,formData)
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
</script>

<style scoped>
.coustom-select {
    height: 100px;
}
.card{
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

.ml-3{
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

.num-of-files{
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
