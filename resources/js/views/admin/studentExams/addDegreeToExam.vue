<template>
    <div class="modal fade" id="add-circle-modal" tabindex="-1"
         aria-labelledby="exampleModalLgLabel" aria-hidden="true" >
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLgLabel">
                        {{$t('role_and_permissions.add degree to exam')}}
                    </h6>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 ">
                            <label class="form-label">{{ $t('global.degree') }}</label>
                            <input type="number" class="form-control" @input="makeMaxNumber('degree',100)" v-model="v$.degree.$model"
                                 :class="{
                                    'is-invalid': v$.degree.$error || errors[`degree`],
                                    'is-valid': !v$.degree.$invalid && !errors[`degree`]
                                }">

                            <div class="invalid-feedback">
                                <span v-if="v$.degree.required.$invalid">{{ $t('validation.fieldRequired') }}<br />
                                </span>
                                <span v-if="v$.degree.numeric.$invalid">{{$t('validation.ThisFieldIsNumeric')}} <br /></span>

                            </div>
                            <template v-if="errors[`degree`]">
                                <error-message v-for="(errorMessage, index) in errors[`degree`]" :key="index">
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
import {maxLength, numeric, required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import adminApi from "../../../api/adminAxios";
import MultiSelect from 'primevue/multiselect';

export default {
    name: "addDegreeToExam",
    props: {
        dataRow: {default: ''},
    },
    components: { MultiSelect },
    data(){
        return {
            errors:{}
        }
    },
    setup(props){
        setTimeout(async () => {
            let myModalEl = document.getElementById('add-circle-modal')
            myModalEl.addEventListener('show.bs.modal', function (event) {
                resetModal();
            })
            myModalEl.addEventListener('hidden.bs.modal', function (event) {
                resetModalHidden();
            })
        }, 150);
        const errors = ref([]);
        const circlesArr = ref([]);
        let loading = ref(false);
        let is_disabled = ref(false);
        const {t} = useI18n({});
        const id = ref(null);

        onMounted(()=>{
        });

       function defaultData(){
           submitdata.data.degree = '';
           is_disabled.value = false;
           loading.value = false;
           errors.value = [];
        }
         
       function resetModal() {
            defaultData();
            setTimeout(async () => {
                id.value = props.dataRow.id;
                submitdata.data.degree = props.dataRow.degree;
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
                degree: '',
            }
        });

        const rules = computed(() => {
            return {
                degree: {required,numeric},
            }
        });

        const v$ = useVuelidate(rules,submitdata.data);

         function makeMaxNumber(field, max) {
            if (submitdata.data[field] > max) {
                submitdata.data[field] = max;
            }
            if (submitdata.data[field] < 0) {
                submitdata.data[field] = 0;
            }
        }

        return {t,id,loading,is_disabled,resetModal,circlesArr,resetModalHidden,...toRefs(submitdata),v$,errors,makeMaxNumber};
    },
    methods: {
        AddSubmit() {

        this.v$.$validate();
        this.errors = {};

        let formData = new FormData();
        formData.append('degree', this.data.degree);

            this.is_disabled = false;
            this.loading = true;
            formData.append('_method','PUT');
            adminApi.post(`dashboard/add-degree-to-exam/${this.id}`,formData)
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
