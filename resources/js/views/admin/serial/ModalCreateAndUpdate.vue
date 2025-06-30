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
                            <label class="form-label">{{ $t('label.type') }}</label>

                            <Select v-model="data.type" :filterFields="['name','label']" :options="types" filter
                                    :invalid="v$.type.$error || errors[`type`]"
                                    optionLabel="label" optionValue="value"
                                    :class="['w-full w-100', { 'is-invalid': v$.type.$error || errors[`type`], 'is-valid': !v$.type.$invalid && !errors[`type`] }]">

                            </Select>
                            <div class="invalid-feedback">
                                <span v-if="v$.type.required.$invalid">{{
                                        $t('global.ThisFieldIsRequired') }}<br />
                                </span>
                            </div>
                            <template v-if="errors['type']">
                                <error-message v-for="(errorMessage, index) in errors['type']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6">
                            <label for="input-prefix" class="form-label">{{$t('label.prefix')}}</label>
                            <input type="text" class="form-control" id="input-prefix" :placeholder="$t('label.prefix')"
                                   v-model.trim="v$.prefix.$model"
                                   :class="{'is-invalid': v$.prefix.$error ||errors[`prefix`],
                                'is-valid':!v$.prefix.$invalid && !errors[`prefix`]}">
                            <div class="invalid-feedback">
                                <span v-if="v$.prefix.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                            </div>
                            <template v-if="errors['prefix']">
                                <error-message v-for="(errorMessage, index) in errors['prefix']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="input-number" class="form-label">{{$t('label.startNumber')}}</label>
                            <input type="number" class="form-control" id="input-number" :placeholder="$t('label.startNumber')"
                                   v-model.trim="v$.start_number.$model"
                                   :class="{'is-invalid': v$.start_number.$error ||errors[`start_number`],
                                'is-valid':!v$.start_number.$invalid && !errors[`start_number`]}">
                            <div class="invalid-feedback">
                                <span v-if="v$.start_number.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                                <span v-if="v$.start_number.numeric.$invalid">{{$t('validation.ThisFieldIsNumeric')}} <br /></span>
                            </div>
                            <template v-if="errors['start_number']">
                                <error-message v-for="(errorMessage, index) in errors['start_number']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
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
import { numeric, required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import adminApi from "../../../api/adminAxios";

export default {
    name: "SerialsModalCreateAndUpdate",
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
        const types = ref([]);
        let loading = ref(false);
        let is_disabled = ref(false);
        const {t} = useI18n({});
        const id = ref(null);

        onMounted(()=>{
        });

      function defaultData(){
           submitdata.data.type = '';
           submitdata.data.prefix = '';
           submitdata.data.start_number = '';
           is_disabled.value = false;
           loading.value = false;
           errors.value = [];
        }

        let getTypesAndModel = () => {
            loading.value = true;

            adminApi.get(`dashboard/serial/enums`)
                .then((res) => {
                    let l = res.data.data;
                    types.value = l.types;
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
                getTypesAndModel();
                if (props.type != 'edit') {
                } else {
                    id.value = props.dataRow.id;
                    submitdata.data.type = props.dataRow.type.value;
                    submitdata.data.prefix = props.dataRow.prefix;
                    submitdata.data.start_number = props.dataRow.start_number;
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
                type: '',
                prefix: '',
                start_number: '',
            }
        });

        const rules = computed(() => {
            return {
                type:{required},
                prefix:{required},
                start_number:{required,numeric}
            }
        });

        const v$ = useVuelidate(rules,submitdata.data);

        return {t,id,
            loading,is_disabled,types,
            resetModal,resetModalHidden
            ,...toRefs(submitdata),
            v$,errors};
    },
    methods: {
        AddSubmit() {

        this.v$.$validate();
        this.errors = {};

        let formData = new FormData();
        formData.append('type', this.data.type);
        formData.append('prefix', this.data.prefix);
        formData.append('start_number', this.data.start_number);
        if (this.type !== 'edit') {
            if (!this.v$.$error) {
                this.is_disabled = false;
                this.loading = true;
                adminApi.post(`dashboard/serial`, formData)
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
            adminApi.post(`dashboard/serial/${this.id}`,formData)
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
