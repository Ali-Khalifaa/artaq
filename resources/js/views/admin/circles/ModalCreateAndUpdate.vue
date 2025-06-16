<template>
    <div class="modal fade" id="category-service" tabindex="-1"
         aria-labelledby="exampleModalLgLabel" aria-hidden="true" >
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLgLabel">
                        {{type == 'create' ? $t('global.add') : $t('global.update')}}
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 ">
                            <label for="name" class="form-label">{{$t('label.title')}}</label>
                            <input type="text" class="form-control" id="name" :placeholder="$t('label.title')"
                                v-model.trim="v$.name.$model"
                                :class="{'is-invalid': v$.name.$error ||errors[`name`],
                                'is-valid':!v$.name.$invalid && !errors[`name`]}">
                            <div class="invalid-feedback">
                                <span v-if="v$.name.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                            </div>
                            <template v-if="errors['name']">
                                <error-message v-for="(errorMessage, index) in errors['name']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">{{ $t('global.selectCircleType') }}</label>

                            <Select v-model="data.circle_type_id" :filterFields="['id','title']" :options="types" filter
                                    :invalid="v$.circle_type_id.$error || errors[`circle_type_id`]"
                                        optionLabel="name" optionValue="id"
                                    :class="['w-full w-100', { 'is-invalid': v$.circle_type_id.$error || errors[`circle_type_id`], 'is-valid': !v$.circle_type_id.$invalid && !errors[`circle_type_id`] }]">

                            </Select>
                            <div class="invalid-feedback">

                            </div>
                            <template v-if="errors['circle_type_id']">
                                <error-message v-for="(errorMessage, index) in errors['circle_type_id']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label">{{$t('global.start_time')}}</label>
                            <input type="time" class="form-control custom-time-picker" @input="changeTimeInDuration" v-model.trim="v$.start_time.$model"
                                :class="{'is-invalid': v$.start_time.$error ||errors[`start_time`],
                                'is-valid':!v$.start_time.$invalid && !errors[`start_time`]}">
                            <div class="invalid-feedback">
                                <span v-if="v$.start_time.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                            </div>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label">{{$t('global.end_time')}}</label>
                            <input type="time" class="form-control custom-time-picker" @input="changeTimeInDuration" v-model.trim="v$.end_time.$model"
                                :class="{'is-invalid': v$.end_time.$error ||errors[`end_time`],
                                'is-valid':!v$.end_time.$invalid && !errors[`end_time`]}">
                            <div class="invalid-feedback">
                                <span v-if="v$.end_time.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                            </div>
                        </div>

                         <div class="col-md-6 mt-3">
                            <div class="row">
                                <label class="form-label mb-1">{{$t('global.StudentType')}}</label>
                                <div class="col-xl-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" v-model="data.gender" value="male" id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            {{$t('global.male')}}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" v-model="data.gender" value="female" id="flexRadioDefault2">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            {{$t('global.female')}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mt-4" v-if="type == 'create'">
                            <div class="custom-toggle-switch d-flex align-items-center mb-4">
                                <input id="toggleswitchPrimary" v-model="data.add_duration" type="checkbox">
                                <label for="toggleswitchPrimary" class="label-primary"></label><span class="ms-3">تخصيص أيام ووقت للحلقة</span>
                            </div>
                            <template v-if="errors['status']">
                                <error-message v-for="(errorMessage, index) in errors['status']" :key="index">
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

                         <div class="col-md-12 mb-3" v-if="data.add_duration">
                            <div class="table-responsive mb-2">
                                <table class="table text-nowrap table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ $t('global.day') }}</th>
                                            <th>{{ $t('global.start_time') }}</th>
                                            <th>{{ $t('global.end_time') }}</th>
                                            <th>{{ $t('global.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(detail, index) in data.duration" :key="index">
                                        <td>
                                            <Select v-model="detail.day"
                                            :filterFields="['id','title']" :options="days"
                                            filter optionLabel="title" optionValue="id" :class="['w-full w-100']">
                                            </Select>
                                            <template v-if="errors['duration.'+index+'.day']">
                                                <error-message v-for="(errorMessage, i) in errors['duration.'+index+'.day']" :key="i">
                                                    {{ errorMessage }}
                                                </error-message>
                                            </template>
                                        </td>
                                        <td>
                                            <input type="time" class="form-control custom-time-picker" v-model="detail.start_time">
                                            <template v-if="errors['duration.'+index+'.start_time']">
                                                <error-message v-for="(errorMessage, i) in errors['duration.'+index+'.start_time']" :key="i">
                                                    {{ errorMessage }}
                                                </error-message>
                                            </template>
                                        </td>
                                        <td>
                                            <input type="time" class="form-control custom-time-picker" v-model="detail.end_time">
                                            <template v-if="errors['duration.'+index+'.end_time']">
                                                <error-message v-for="(errorMessage, i) in errors['duration.'+index+'.end_time']" :key="i">
                                                    {{ errorMessage }}
                                                </error-message>
                                            </template>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm me-2" v-if="index > 0" @click="removeDetail(index)" >
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary btn-sm" @click="addDetail">
                                                <i class="ri-add-line"></i>
                                            </button>
                                        </td>

                                        </tr>
                                    </tbody>
                            </table>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button v-if="type != 'edit'" :disabled="!is_disabled"
                            @click.prevent="resetModal" type="button" class="btn btn-secondary">{{$t('global.AddNewRecord')}}</button>
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
import {maxLength, requiredIf,minLength, required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import adminApi from "../../../api/adminAxios";

export default {
    name: "CircleTypesModal",
    props: {
        type: {default: 'create'},
        dataRow: {default: ''},
    },
    data(){
        return {
            errors:{}
        }
    },
    setup(props){
        setTimeout(async () => {
            let myModalEl = document.getElementById('category-service')
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
        const {t} = useI18n({});
        const id = ref(null);
        let types = ref([]);

        let days = ref([
            { id: 'Saturday', title: 'السبت' },
            { id: 'Sunday', title: 'الأحد' },
            { id: 'Monday', title: 'الأثنين' },
            { id: 'Tuesday', title: 'الثلاثاء' },
            { id: 'Wednesday', title: 'الأربعاء' },
            { id: 'Thursday', title: 'الخميس' },
            { id: 'Friday', title: 'الجمعه' },
        ]);


        onMounted(()=>{
             /* For Time Picker */
            flatpickr("#timepikcr", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
            });
        });

       function defaultData(){
           submitdata.data.name = '';
           submitdata.data.circle_type_id = '';
           submitdata.data.gender = 'male';
           submitdata.data.add_duration = false;
           submitdata.data.duration = [{'day' : 'Saturday','start_time':'','end_time':''}];
           submitdata.data.start_time = '';
           submitdata.data.end_time = '';
           submitdata.data.status = true;
           is_disabled.value = false;
           loading.value = false;
           errors.value = [];
        }

         let getType = () => {
            loading.value = true;

            adminApi.get(`dashboard/circle-types-dropdown`)
                .then((res) => {
                    let l = res.data.data;
                    types.value = l;
                })
                .catch((err) => {
                    console.log(err.response.data);
                })
                .finally(() => {
                    loading.value = false;
                })
        }

        function addDetail() {
            submitdata.data.duration.push({
                day: '',
                start_time: submitdata.data.start_time,
                end_time: submitdata.data.end_time
            })
        }
        function removeDetail(index) {
            submitdata.data.duration.splice(index, 1);
        }

       function resetModal() {
            defaultData();
            setTimeout(async () => {
                getType();
                if (props.type != 'edit') {
                } else {
                    id.value = props.dataRow.id;
                    submitdata.data.name = props.dataRow.name;
                    submitdata.data.circle_type_id = props.dataRow.circle_type_id;
                    submitdata.data.gender = props.dataRow.gender;
                    submitdata.data.start_time = props.dataRow.start_time;
                    submitdata.data.end_time = props.dataRow.end_time;
                    submitdata.data.duration = props.dataRow.duration;
                    submitdata.data.add_duration = true;
                    submitdata.data.status = props.dataRow.status == 1;
                }
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
                name: '',
                circle_type_id: '',
                 status: true,
                gender: 'male',
                add_duration: false,
                duration: [
                    {'day' : 'Saturday','start_time':'','end_time':''}
                ],
                start_time: '',
                end_time: ''
            }
        });

        const rules = computed(() => {
            return {
                name: {required},
                circle_type_id: {},
                start_time: {
                    required: requiredIf(function (model) {
                            return !submitdata.data.add_duration;
                        })
                },
                end_time: {
                    required: requiredIf(function (model) {
                            return !submitdata.data.add_duration;
                        })
                },

            }
        });

        const v$ = useVuelidate(rules,submitdata.data);

        function changeTimeInDuration() {
            if (!submitdata.data.add_duration) {
                submitdata.data.duration.forEach((item) => {
                    item.start_time = submitdata.data.start_time;
                    item.end_time = submitdata.data.end_time;
                });
            }
        }

        return {t,id,changeTimeInDuration,types,days,addDetail,removeDetail,loading,is_disabled,resetModal,resetModalHidden,...toRefs(submitdata),v$,errors};
    },
    methods: {
        AddSubmit() {

        this.v$.$validate();
        this.errors = {};

        let formData = new FormData();
        formData.append('name', this.data.name);
        formData.append('circle_type_id', this.data.circle_type_id ?? '');
        formData.append('gender', this.data.gender ?? '');
        formData.append('start_time', this.data.start_time);
        formData.append('end_time', this.data.end_time);
        formData.append('status', this.data.status ? 1 : 0);
        if(!this.data.add_duration) {
            this.days.forEach((item, index) => {
                formData.append(`duration[${index}][day]`, item.id);
                formData.append(`duration[${index}][start_time]`, this.data.start_time);
                formData.append(`duration[${index}][end_time]`, this.data.end_time);
            });
        } else {
            this.data.duration.forEach((item, index) => {
                formData.append(`duration[${index}][day]`, item.day);
                formData.append(`duration[${index}][start_time]`, item.start_time);
                formData.append(`duration[${index}][end_time]`, item.end_time);
            });

        }

        if (this.type !== 'edit') {
            if (!this.v$.$error) {
                this.is_disabled = false;
                this.loading = true;
                adminApi.post(`dashboard/circles`, formData)
                    .then((res) => {
                        Swal.fire({
                            icon: 'success',
                            title: `${this.t('global.AddedSuccessfully')}`,
                            showConfirmButton: false,
                            timer: 1500
                        });
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
            }
        }else if(!this.v$.$error) {
            this.is_disabled = false;
            this.loading = true;
            formData.append('_method','PUT');
            adminApi.post(`dashboard/circles/${this.id}`,formData)
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


  .custom-time-picker::-webkit-calendar-picker-indicator {
    filter: invert(50%); /* Adjust icon color */
  }
</style>
