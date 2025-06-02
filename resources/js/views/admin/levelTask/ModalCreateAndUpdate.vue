<template>
    <div class="modal fade" id="category-service" tabindex="-1"
         aria-labelledby="exampleModalLgLabel" aria-hidden="true" >
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLgLabel">
                        {{type == 'create' ? $t('global.add') : $t('global.update')}}
                    </h6>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6">
                            <label class="form-label">{{ $t('global.selectMemorizationType') }}</label>

                            <Select v-model="data.preservation_method_id" :filterFields="['id','name']" @change="getLevels" :options="types" filter
                                    :invalid="v$.preservation_method_id.$error || errors[`preservation_method_id`]"
                                        optionLabel="name" optionValue="id"
                                    :class="['w-full w-100', { 'is-invalid': v$.preservation_method_id.$error || errors[`preservation_method_id`], 'is-valid': !v$.preservation_method_id.$invalid && !errors[`preservation_method_id`] }]">

                            </Select>
                            <div class="invalid-feedback">
                                <span v-if="v$.preservation_method_id.required.$invalid">{{
                                        $t('global.ThisFieldIsRequired') }}<br />
                                </span>
                            </div>
                            <template v-if="errors['preservation_method_id']">
                                <error-message v-for="(errorMessage, index) in errors['preservation_method_id']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">{{ $t('global.selectLevel') }}</label>

                            <Select v-model="data.level_id" :filterFields="['id','name']" :options="levels" filter
                                    :invalid="v$.level_id.$error || errors[`level_id`]"
                                        optionLabel="name" optionValue="id"
                                    :class="['w-full w-100', { 'is-invalid': v$.level_id.$error || errors[`level_id`], 'is-valid': !v$.level_id.$invalid && !errors[`level_id`] }]">

                            </Select>
                            <div class="invalid-feedback">
                                <span v-if="v$.level_id.required.$invalid">{{
                                        $t('global.ThisFieldIsRequired') }}<br />
                                </span>
                            </div>
                            <template v-if="errors['level_id']">
                                <error-message v-for="(errorMessage, index) in errors['level_id']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                         <div class="col-md-6 mt-3">
                            <label class="form-label">{{ $t('global.fromSurah') }}</label>

                            <Select v-model="data.from_surah_id" :filterFields="['id','normalized_name']" @change="getFromAyah" :options="surahs" filter
                                    :invalid="v$.from_surah_id.$error || errors[`from_surah_id`]"
                                        optionLabel="name" optionValue="id"
                                    :class="['w-full w-100', { 'is-invalid': v$.from_surah_id.$error || errors[`from_surah_id`], 'is-valid': !v$.from_surah_id.$invalid && !errors[`from_surah_id`] }]">

                            </Select>
                            <div class="invalid-feedback">
                                <span v-if="v$.from_surah_id.required.$invalid">{{
                                        $t('global.ThisFieldIsRequired') }}<br />
                                </span>
                            </div>
                            <template v-if="errors['from_surah_id']">
                                <error-message v-for="(errorMessage, index) in errors['from_surah_id']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label">{{ $t('global.toSurah') }}</label>

                            <Select v-model="data.to_surah_id" :filterFields="['id','normalized_name']" @change="getToAyah" :options="surahs" filter
                                    :invalid="v$.to_surah_id.$error || errors[`to_surah_id`]"
                                        optionLabel="name" optionValue="id"
                                    :class="['w-full w-100', { 'is-invalid': v$.to_surah_id.$error || errors[`to_surah_id`], 'is-valid': !v$.to_surah_id.$invalid && !errors[`to_surah_id`] }]">

                            </Select>
                            <div class="invalid-feedback">
                                <span v-if="v$.to_surah_id.required.$invalid">{{
                                        $t('global.ThisFieldIsRequired') }}<br />
                                </span>
                            </div>
                            <template v-if="errors['to_surah_id']">
                                <error-message v-for="(errorMessage, index) in errors['to_surah_id']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label">{{ $t('global.fromAyah') }}</label>

                            <Select v-model="data.from_ayah_id" :filterFields="['id','text','text_normalized','number_in_surah']" :options="fromAyah" filter
                                    :invalid="v$.from_ayah_id.$error || errors[`from_ayah_id`]"
                                        optionLabel="text" optionValue="id"
                                    :class="['w-full w-100', { 'is-invalid': v$.from_ayah_id.$error || errors[`from_ayah_id`], 'is-valid': !v$.from_ayah_id.$invalid && !errors[`from_ayah_id`] }]">

                            </Select>
                            <div class="invalid-feedback">
                                <span v-if="v$.from_ayah_id.required.$invalid">{{
                                        $t('global.ThisFieldIsRequired') }}<br />
                                </span>
                            </div>
                            <template v-if="errors['from_ayah_id']">
                                <error-message v-for="(errorMessage, index) in errors['from_ayah_id']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label">{{ $t('global.toAyah') }}</label>

                            <Select v-model="data.to_ayah_id" :filterFields="['id','text','text_normalized','number_in_surah']" :options="toAyah" filter
                                    :invalid="v$.to_ayah_id.$error || errors[`to_ayah_id`]"
                                        optionLabel="text" optionValue="id"
                                    :class="['w-full w-100', { 'is-invalid': v$.to_ayah_id.$error || errors[`to_ayah_id`], 'is-valid': !v$.to_ayah_id.$invalid && !errors[`to_ayah_id`] }]">

                            </Select>
                            <div class="invalid-feedback">
                                <span v-if="v$.to_ayah_id.required.$invalid">{{
                                        $t('global.ThisFieldIsRequired') }}<br />
                                </span>
                            </div>
                            <template v-if="errors['to_ayah_id']">
                                <error-message v-for="(errorMessage, index) in errors['to_ayah_id']" :key="index">
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
    name: "levels",
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
        let levels = ref([]);
        let surahs = ref([]);
        let fromAyah = ref([]);
        let toAyah = ref([]);

        onMounted(()=>{
        });

         let getMemorizationType = () => {
            loading.value = true;

            adminApi.get(`dashboard/memorization-types-dropdown`)
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

        let getLevels = () => {
            loading.value = true;
            levels.value = [];
            submitdata.data.level_id = '';

            adminApi.get(`dashboard/levels/dropdown?preservation_method_id=${submitdata.data.preservation_method_id}`)
                .then((res) => {
                    let l = res.data.data;
                    levels.value = l;
                })
                .catch((err) => {
                    console.log(err.response.data);
                })
                .finally(() => {
                    loading.value = false;
                })
        }

         let getSurahs = () => {
            loading.value = true;

            adminApi.get(`dashboard/surah-dropdown`)
                .then((res) => {
                    let l = res.data.data;
                    surahs.value = l;
                })
                .catch((err) => {
                    console.log(err.response.data);
                })
                .finally(() => {
                    loading.value = false;
                })
        }

        let getFromAyah = () => {
            loading.value = true;
            fromAyah.value = [];
            submitdata.data.from_ayah_id = '';

            adminApi.get(`dashboard/ayahs-by-surah/${submitdata.data.from_surah_id}`)
                .then((res) => {
                    let l = res.data.data;
                    fromAyah.value = l;
                    fromAyah.value.forEach((ayah) => {
                        if (ayah.text_normalized.length > 100) {
                            ayah.text = ' ('+makeNumberArabic(ayah.number_in_surah)+') '+ayah.text.substring(0, 100) + '...';
                        }else{
                            ayah.text = ' ('+makeNumberArabic(ayah.number_in_surah)+') '+ayah.text;
                        }
                    });
                })
                .catch((err) => {
                    console.log(err.response.data);
                })
                .finally(() => {
                    loading.value = false;
                })
        }

        let getToAyah = () => {
            loading.value = true;
            toAyah.value = [];
            submitdata.data.to_ayah_id = '';

            adminApi.get(`dashboard/ayahs-by-surah/${submitdata.data.to_surah_id}`)
                .then((res) => {
                    let l = res.data.data;
                    toAyah.value = l;
                    toAyah.value.forEach((ayah) => {
                        if (ayah.text_normalized.length > 100) {
                            ayah.text = ' ('+makeNumberArabic(ayah.number_in_surah)+') '+ayah.text.substring(0, 100) + '...';
                        }else{
                            ayah.text = ' ('+makeNumberArabic(ayah.number_in_surah)+') '+ayah.text;
                        }
                    });
                })
                .catch((err) => {
                    console.log(err.response.data);
                })
                .finally(() => {
                    loading.value = false;
                })
        }

        let makeNumberArabic = (num) => {
            if (typeof num !== 'number') {
                return num; // Return as is if not a number
            }
            return num.toString().replace(/\d/g, d => '٠١٢٣٤٥٦٧٨٩'[d]);
        }

       function defaultData(){
           submitdata.data.preservation_method_id = '';
           submitdata.data.level_id = '';
            submitdata.data.from_surah_id = '';
            submitdata.data.to_surah_id = '';
            submitdata.data.from_ayah_id = '';
            submitdata.data.to_ayah_id = '';
           is_disabled.value = false;
           loading.value = false;
           errors.value = [];
        }

       function resetModal() {
            defaultData();
            setTimeout(async () => {
                getMemorizationType();
                getSurahs();
                if (props.type != 'edit') {
                } else {
                    id.value = props.dataRow.id;
                    submitdata.data.preservation_method_id = props.dataRow.preservation_method_id;
                    submitdata.data.from_surah_id = props.dataRow.from_surah_id;
                    submitdata.data.to_surah_id = props.dataRow.to_surah_id;
                    getLevels();
                    submitdata.data.level_id = props.dataRow.level_id;
                    getFromAyah();
                    submitdata.data.from_ayah_id = props.dataRow.from_ayah_id;
                    getToAyah();
                    submitdata.data.to_ayah_id = props.dataRow.to_ayah_id;
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
                preservation_method_id: '',
                level_id: '',
                from_surah_id: '',
                to_surah_id: '',
                from_ayah_id: '',
                to_ayah_id: '',
            }
        });

        const rules = computed(() => {
            return {
                preservation_method_id: {required},
                level_id: {required},
                from_surah_id: {required},
                to_surah_id: {required},
                from_ayah_id: {required},
                to_ayah_id: {required},
            }
        });

        const v$ = useVuelidate(rules,submitdata.data);

        return {t,id,loading,is_disabled,resetModal,resetModalHidden,...toRefs(submitdata),v$,errors,types,levels,getLevels,surahs,
            fromAyah,toAyah,getFromAyah,getToAyah};
    },
    methods: {
        AddSubmit() {

        this.v$.$validate();
        this.errors = {};

        let formData = new FormData();
        formData.append('level_id', this.data.level_id);
        formData.append('from_surah_id', this.data.from_surah_id);
        formData.append('to_surah_id', this.data.to_surah_id);
        formData.append('from_ayah_id', this.data.from_ayah_id);
        formData.append('to_ayah_id', this.data.to_ayah_id);
        if (this.type !== 'edit') {
            if (!this.v$.$error) {
                this.is_disabled = false;
                this.loading = true;
                adminApi.post(`dashboard/level-tasks`, formData)
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
            adminApi.post(`dashboard/level-tasks/${this.id}`,formData)
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
