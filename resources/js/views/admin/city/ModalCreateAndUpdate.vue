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
                            <label class="form-label">{{ $t('global.selectCountry') }}</label>

                            <Select v-model="data.country_id" :filterFields="['id','title']" :options="countries" filter
                                    :invalid="v$.country_id.$error || errors[`country_id`]"
                                        optionLabel="name" optionValue="id"
                                    :class="['w-full w-100', { 'is-invalid': v$.country_id.$error || errors[`country_id`], 'is-valid': !v$.country_id.$invalid && !errors[`country_id`] }]">

                            </Select>
                            <div class="invalid-feedback">
                                <span v-if="v$.country_id.required.$invalid">{{
                                        $t('global.ThisFieldIsRequired') }}<br />
                                </span>
                            </div>
                            <template v-if="errors['country_id']">
                                <error-message v-for="(errorMessage, index) in errors['country_id']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>
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
import {maxLength, minLength, required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import adminApi from "../../../api/adminAxios";

export default {
    name: "Category",
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
        const countries = ref([]);
        let loading = ref(false);
        let is_disabled = ref(false);
        const {t} = useI18n({});
        const id = ref(null);

        onMounted(()=>{
        });

       function defaultData(){
           submitdata.data.name = '';
           submitdata.data.country_id = '';
           is_disabled.value = false;
           loading.value = false;
           errors.value = [];
        }
         let getCountries = () => {
            loading.value = true;

            adminApi.get(`dashboard/countries/dropdown`)
                .then((res) => {
                    let l = res.data.data;
                    countries.value = l;
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
                getCountries();
                if (props.type != 'edit') {
                } else {
                    id.value = props.dataRow.id;
                    submitdata.data.name = props.dataRow.name;
                    submitdata.data.country_id = props.dataRow.country_id;

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
                country_id: '',
                name: '',
            }
        });

        const rules = computed(() => {
            return {
                country_id: {required},
                name: {required},
            }
        });

        const v$ = useVuelidate(rules,submitdata.data);

        return {t,id,loading,is_disabled,resetModal,countries,resetModalHidden,...toRefs(submitdata),v$,errors};
    },
    methods: {
        AddSubmit() {

        this.v$.$validate();
        this.errors = {};

        let formData = new FormData();
        formData.append('name', this.data.name);
        formData.append('country_id', this.data.country_id);
        if (this.type !== 'edit') {
            if (!this.v$.$error) {
                this.is_disabled = false;
                this.loading = true;
                adminApi.post(`dashboard/cities`, formData)
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
            adminApi.post(`dashboard/cities/${this.id}`,formData)
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
