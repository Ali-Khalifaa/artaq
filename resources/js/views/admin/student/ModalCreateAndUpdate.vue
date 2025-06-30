<template>
    <div class="modal fade" id="admin-modal" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="adminModalLabel">
                        {{ type == 'create' ? $t('global.add') : $t('global.update') }}
                    </h6>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6">
                            <label class="form-label">{{ $t('global.Three-part name') }}</label>
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
                            <label class="form-label">{{ $t('global.phone') }}</label>
                            <input type="text" class="form-control" v-model.trim="v$.phone.$model"
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

                        <div class="col-md-6 mt-3">
                            <label class="form-label">{{ $t('global.guardian') }}</label>
                            <input type="text" class="form-control" v-model="v$.guardian.$model"
                                 :class="{
                                    'is-invalid': v$.guardian.$error || errors[`guardian`],
                                    'is-valid': !v$.guardian.$invalid && !errors[`guardian`]
                                }">

                            <div class="invalid-feedback">
                                <span v-if="v$.guardian.required.$invalid">{{ $t('validation.fieldRequired') }}<br />
                                </span>

                            </div>
                            <template v-if="errors[`guardian`]">
                                <error-message v-for="(errorMessage, index) in errors[`guardian`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label">{{ $t('global.guardian_phone') }}</label>
                            <input type="text" class="form-control" v-model.trim="v$.guardian_phone.$model"
                                :class="{ 'is-invalid': v$.guardian_phone.$error || errors[`guardian_phone`], 'is-valid': !v$.guardian_phone.$invalid  && !errors[`guardian_phone`] }"
                                :placeholder="$t('global.guardian_phone')">
                            <div class="valid-feedback">{{ $t('global.LooksGood') }}</div>
                            <div class="invalid-feedback">
                                <span v-if="v$.guardian_phone.required.$invalid">{{
                                    $t('global.PhoneIsRequired') }} <br /></span>
                                <span v-if="v$.guardian_phone.minLength.$invalid">{{
                                    $t('global.PhoneIsMustHaveAtLeast') }} {{
                                        v$.guardian_phone.minLength.$params.min
                                    }} {{ $t('global.Letters') }} <br /></span>
                                <span v-if="v$.guardian_phone.maxLength.$invalid">{{
                                    $t('global.PhoneIsMustHaveAtMost') }} {{
                                        v$.guardian_phone.maxLength.$params.max
                                    }} {{ $t('global.Letters') }} </span>
                            </div>
                            <template v-if="errors['guardian_phone']">
                                <error-message v-for="(errorMessage, index) in errors['guardian_phone']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6 mt-3">
                            <div class="row">
                                <label class="form-label mb-1">{{$t('global.gender')}}</label>
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

                        <div class="col-md-6 mt-3">
                            <label class="form-label">{{ $t('global.selectNationality') }}</label>

                            <Select v-model="data.nationality_id" :filterFields="['id','name']" :options="nationalities" filter
                                    :invalid="v$.nationality_id.$error || errors[`nationality_id`]"
                                        optionLabel="name" optionValue="id"
                                    :class="['w-full w-100', { 'is-invalid': v$.nationality_id.$error || errors[`nationality_id`], 'is-valid': !v$.nationality_id.$invalid && !errors[`nationality_id`] }]">

                            </Select>
                            <div class="invalid-feedback">
                                <span v-if="v$.nationality_id.required.$invalid">{{
                                        $t('global.ThisFieldIsRequired') }}<br />
                                </span>
                            </div>
                            <template v-if="errors['nationality_id']">
                                <error-message v-for="(errorMessage, index) in errors['nationality_id']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label">{{ $t('global.birth_date') }}</label>
                            <input type="text" class="form-control" id="date" v-model="v$.birth_date.$model"
                                 :class="{
                                    'is-invalid': v$.birth_date.$error || errors[`birth_date`],
                                    'is-valid': !v$.birth_date.$invalid && !errors[`birth_date`]
                                }">

                            <div class="invalid-feedback">
                                <span v-if="v$.birth_date.required.$invalid">{{ $t('validation.fieldRequired') }}<br />
                                </span>

                            </div>
                            <template v-if="errors[`birth_date`]">
                                <error-message v-for="(errorMessage, index) in errors[`birth_date`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label">{{ $t('global.id_number') }}</label>
                            <input type="text" class="form-control" v-model="v$.id_number.$model"
                                 :class="{
                                    'is-invalid': v$.id_number.$error || errors[`id_number`],
                                    'is-valid': !v$.id_number.$invalid && !errors[`id_number`]
                                }">

                            <div class="invalid-feedback">
                                <span v-if="v$.id_number.required.$invalid">{{ $t('validation.fieldRequired') }}<br />
                                </span>

                            </div>
                            <template v-if="errors[`id_number`]">
                                <error-message v-for="(errorMessage, index) in errors[`id_number`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                         <div class="col-md-6 mt-3">
                            <label class="form-label">{{ $t('global.selectCountry') }}</label>

                            <Select v-model="data.country_id" :filterFields="['id','name']" @change="getCitiesByCountryId" :options="countries" filter
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

                        <div class="col-md-6 mt-3">
                            <label class="form-label">{{ $t('global.selectCity') }}</label>

                            <Select v-model="data.city_id" :filterFields="['id','name']" :options="cities" filter
                                    :invalid="v$.city_id.$error || errors[`city_id`]"
                                        optionLabel="name" optionValue="id"
                                    :class="['w-full w-100', { 'is-invalid': v$.city_id.$error || errors[`city_id`], 'is-valid': !v$.city_id.$invalid && !errors[`city_id`] }]">
                            </Select>
                            <div class="invalid-feedback">
                                <span v-if="v$.city_id.required.$invalid">{{$t('global.ThisFieldIsRequired') }}<br/></span>
                            </div>
                            <template v-if="errors['city_id']">
                                <error-message v-for="(errorMessage, index) in errors['city_id']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                         <div class="col-md-6 mt-3">
                            <label class="form-label">{{ $t('global.selectMemorizationAmount') }}</label>

                            <Select v-model="data.memorization_amount_id" :filterFields="['id','name']" :options="amounts" filter
                                    :invalid="v$.memorization_amount_id.$error || errors[`memorization_amount_id`]"
                                        optionLabel="name" optionValue="id"
                                    :class="['w-full w-100', { 'is-invalid': v$.memorization_amount_id.$error || errors[`memorization_amount_id`], 'is-valid': !v$.memorization_amount_id.$invalid && !errors[`memorization_amount_id`] }]">

                            </Select>
                            <div class="invalid-feedback">
                                <span v-if="v$.memorization_amount_id.required.$invalid">{{
                                        $t('global.ThisFieldIsRequired') }}<br />
                                </span>
                            </div>
                            <template v-if="errors['memorization_amount_id']">
                                <error-message v-for="(errorMessage, index) in errors['memorization_amount_id']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label">{{ $t('global.selectTrack') }}</label>

                            <Select v-model="data.track_id" :filterFields="['id','name']" @change="getMemorizationType" :options="tracks" filter
                                    :invalid="v$.track_id.$error || errors[`track_id`]"
                                        optionLabel="name" optionValue="id"
                                    :class="['w-full w-100', { 'is-invalid': v$.track_id.$error || errors[`track_id`], 'is-valid': !v$.track_id.$invalid && !errors[`track_id`] }]">

                            </Select>
                            <div class="invalid-feedback">
                                <span v-if="v$.track_id.required.$invalid">{{
                                        $t('global.ThisFieldIsRequired') }}<br />
                                </span>
                            </div>
                            <template v-if="errors['track_id']">
                                <error-message v-for="(errorMessage, index) in errors['track_id']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label">{{ $t('global.selectMemorizationType') }}</label>

                            <Select v-model="data.preservation_method_id" :filterFields="['id','name']" @change="getLevels" :options="types" filter
                                    :invalid="v$.preservation_method_id.$error || errors[`preservation_method_id`]"
                                        optionLabel="name" optionValue="id"
                                    :class="['w-full w-100', { 'is-invalid': v$.preservation_method_id.$error || errors[`preservation_method_id`], 'is-valid': !v$.preservation_method_id.$invalid && !errors[`preservation_method_id`] }]">

                            </Select>
                            <div class="invalid-feedback">
                                <!-- <span v-if="v$.preservation_method_id.required.$invalid">{{
                                        $t('global.ThisFieldIsRequired') }}<br />
                                </span> -->
                            </div>
                            <template v-if="errors['preservation_method_id']">
                                <error-message v-for="(errorMessage, index) in errors['preservation_method_id']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label">{{ $t('global.selectLevel') }}</label>

                            <Select v-model="data.level_id" :filterFields="['id','name']" @change="levelDetail" :options="levels" filter
                                    :invalid="v$.level_id.$error || errors[`level_id`]"
                                        optionLabel="name" optionValue="id"
                                    :class="['w-full w-100', { 'is-invalid': v$.level_id.$error || errors[`level_id`], 'is-valid': !v$.level_id.$invalid && !errors[`level_id`] }]">

                            </Select>
                            <div class="invalid-feedback">
                                <!-- <span v-if="v$.level_id.required.$invalid">{{
                                        $t('global.ThisFieldIsRequired') }}<br />
                                </span> -->
                            </div>
                            <template v-if="errors['level_id']">
                                <error-message v-for="(errorMessage, index) in errors['level_id']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>

                            <div class="table-responsive" v-if="data.level_id && level_details">
                                <table class="table text-nowrap table-success table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">{{ $t('global.Juz') }}</th>
                                            <th scope="col">{{ $t('global.surah_name') }}</th>
                                            <th scope="col">{{ $t('global.Ayah_number') }}</th>
                                            <th scope="col">{{ $t('global.page_num') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">{{ $t('global.from') }}</th>
                                            <td>{{level_details.juz}}</td>
                                            <td>{{level_details.first_sour}}</td>
                                            <td>{{level_details.first_ayah}}</td>
                                            <td>{{level_details.first_page}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ $t('global.to') }}</th>
                                             <td>{{level_details.juz}}</td>
                                            <td>{{level_details.last_sour}}</td>
                                            <td>{{level_details.last_ayah}}</td>
                                            <td>{{level_details.last_page}}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6  mt-3">
                            <label class="form-label">{{ $t('global.password')}}</label>
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

                        <div class="col-md-6  mt-3">
                            <label class="form-label">{{ $t('global.password_confirmation')}}</label>
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

                         <div class="col-md-6 mt-3">
                            <label class="form-label">{{ $t('global.juz_count') }}</label>
                            <input type="number" class="form-control" @input="makeMaxNumber('juz_count',30)" v-model="v$.juz_count.$model"
                                 :class="{
                                    'is-invalid': v$.juz_count.$error || errors[`juz_count`],
                                    'is-valid': !v$.juz_count.$invalid && !errors[`juz_count`]
                                }">

                            <div class="invalid-feedback">
                                <span v-if="v$.juz_count.required.$invalid">{{ $t('validation.fieldRequired') }}<br />
                                </span>
                                <span v-if="v$.juz_count.numeric.$invalid">{{$t('validation.ThisFieldIsNumeric')}} <br /></span>

                            </div>
                            <template v-if="errors[`juz_count`]">
                                <error-message v-for="(errorMessage, index) in errors[`juz_count`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6 mt-4">
                            <div class="custom-toggle-switch d-flex align-items-center mb-4">
                                <input id="toggleswitchPrimary" v-model="data.status" type="checkbox">
                                <label for="toggleswitchPrimary" class="label-primary"></label><span class="ms-3">{{
                                    $t('global.Activate the account')
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

                                <span v-if="type != 'edit' && !numberOfImage" style="width: 90%; height: 90%; margin-top: 30%">
                                    {{ $t('global.ChooseImages') }}
                                    <br><i class="bi bi-cloud-upload fs-40"></i>
                                    <i class="fas fa-cloud-upload-alt ml-3" aria-hidden="true"></i>
                                </span>

                                <div id="container-images" v-show="image && numberOfImage"></div>

                                <div v-if="type == 'edit'" v-show="!numberOfImage">
                                    <figure>
                                        <figcaption>
                                            <img class="img-fluid rounded" style="max-width: 150px; height: 150px" :src="`${imageUpload}`">
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
import { maxLength, minLength, required, sameAs, alphaNum, requiredIf ,numeric} from "@vuelidate/validators";
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

        let types = ref([]);
        let levels = ref([]);
        let amounts = ref([]);
        let nationalities = ref([]);
        let countries = ref([]);
        let cities = ref([]);
        let tracks = ref([]);
        let level_details = ref('');

         onMounted(async ()=>{
            flatpickr("#date", {});
        })

        let getLevels = () => {
            loading.value = true;
            levels.value = [];
            submitdata.data.level_id = '';
            level_details.value = '';

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
        let getMemorizationAmounts = () => {
            loading.value = true;

            adminApi.get(`dashboard/memorization-amounts-dropdown`)
                .then((res) => {
                    let l = res.data.data;
                    amounts.value = l;
                })
                .catch((err) => {
                    console.log(err.response.data);
                })
                .finally(() => {
                    loading.value = false;
                })
        }
        let getMemorizationType = () => {
            loading.value = true;
            types.value = [];
            levels.value = [];
            submitdata.data.preservation_method_id = '';
            submitdata.data.level_id = '';

            adminApi.get(`dashboard/memorization-types-dropdown?track_id=${submitdata.data.track_id}`)
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
        let getNationalities = () => {
            loading.value = true;

            adminApi.get(`dashboard/nationalities-dropdown`)
                .then((res) => {
                    let l = res.data.data;
                    nationalities.value = l;
                })
                .catch((err) => {
                    console.log(err.response.data);
                })
                .finally(() => {
                    loading.value = false;
                })
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
        let getCitiesByCountryId = () => {
            cities.value = [];
            submitdata.data.city_id = '';
            loading.value = true;

            adminApi.get(`dashboard/cities-by-country/${submitdata.data.country_id}`)
                .then((res) => {
                    let l = res.data.data;
                    cities.value = l;
                })
                .catch((err) => {
                    console.log(err.response.data);
                })
                .finally(() => {
                    loading.value = false;
                })
        }
        let getTracks = () => {
            loading.value = true;

            adminApi.get(`dashboard/tracks-dropdown`)
                .then((res) => {
                    let l = res.data.data;
                    tracks.value = l;
                })
                .catch((err) => {
                    console.log(err.response.data);
                })
                .finally(() => {
                    loading.value = false;
                })
        }

        function defaultData() {
            submitdata.data.status = true;
            submitdata.data.name = '';
            submitdata.data.birth_date = '';
            submitdata.data.level_id = '';
            submitdata.data.phone = '';
            submitdata.data.guardian = '';
            submitdata.data.guardian_phone = '';
            submitdata.data.preservation_method_id = '';
            submitdata.data.memorization_amount_id = '';
            submitdata.data.track_id = '';
            submitdata.data.nationality_id = 2;
            submitdata.data.country_id = '';
            submitdata.data.city_id = '';
            submitdata.data.gender = 'male';
            submitdata.data.password = '';
            submitdata.data.confirmation = '';
            submitdata.data.id_number = '';
            submitdata.data.juz_count = '';
            imageUpload.value = '';
            is_disabled.value = false;
            image.value = null
            errors.value = [];
            empty();
        }
        function resetModal() {
            defaultData();
            setTimeout(async () => {
                getTracks();
                getMemorizationAmounts();
                getNationalities();
                getCountries();
                if (props.type != 'edit') {
                } else {
                    id.value = props.dataRow.id;
                    submitdata.data.name = props.dataRow.name;
                    submitdata.data.birth_date = props.dataRow.birth_date;
                    submitdata.data.phone = props.dataRow.phone;
                    submitdata.data.guardian = props.dataRow.guardian;
                    submitdata.data.guardian_phone = props.dataRow.guardian_phone;

                    submitdata.data.memorization_amount_id = props.dataRow.memorization_amount_id;
                    submitdata.data.nationality_id = props.dataRow.nationality_id;
                    submitdata.data.track_id = props.dataRow.track_id;
                    submitdata.data.country_id = props.dataRow.country_id;
                    submitdata.data.gender = props.dataRow.gender;
                    submitdata.data.id_number = props.dataRow.id_number;
                    submitdata.data.juz_count = props.dataRow.juz_count;
                    submitdata.data.status = props.dataRow.status == 1;
                    imageUpload.value = props.dataRow.image;
                    if (submitdata.data.country_id) {
                        getCitiesByCountryId();
                        submitdata.data.city_id = props.dataRow.city_id;
                    }

                    getMemorizationType();
                    submitdata.data.preservation_method_id = props.dataRow.preservation_method_id;

                    getLevels();
                    submitdata.data.level_id = props.dataRow.level_id;
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
                birth_date: '',
                level_id: '',
                phone: '',
                guardian: '',
                guardian_phone: '',
                preservation_method_id: '',
                memorization_amount_id: '',
                track_id: '',
                nationality_id: 2,
                country_id: '',
                city_id: '',
                id_number: '',
                juz_count: '',
                gender: 'male',

                password: '',
                confirmation: '',
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
                img.style.maxWidth = '150px';
                img.style.height = '150px';
                figure.insertBefore(img, figcap);
            }

            containerImages.appendChild(figure);
            reader.readAsDataURL(image.value);

        }

        // validation image
        const requiredn = ref(false);

        // watch(numberOfImage, (count, prevCount) => {
        //     if (!count) {
        //         requiredn.value = true;
        //     } else {
        //         requiredn.value = false;
        //     }
        // });

        const rules = computed(() => {
            return {
                name: {
                    minLength: minLength(3),
                    maxLength: maxLength(100),
                    required
                },
                birth_date: {
                    required
                },
                level_id: {
                    // required
                },
                id_number: {
                    required
                },
                juz_count: {
                    required,numeric,
                },
                 phone: {
                    required,
                    minLength: minLength(10),
                    maxLength: maxLength(20)
                },
                guardian: {
                    required
                },
                guardian_phone: {
                    required,
                    minLength: minLength(10),
                    maxLength: maxLength(20)
                },
                preservation_method_id: {
                    // required
                },
                memorization_amount_id: {
                    required
                },
                track_id: {
                    required
                },
                nationality_id: {
                    required
                },
                country_id: {
                    required
                },
                city_id: {
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


            }
        });

        const v$ = useVuelidate(rules, submitdata.data);

        function makeMaxNumber(field, max) {
            if (submitdata.data[field] > max) {
                submitdata.data[field] = max;
            }
            if (submitdata.data[field] < 0) {
                submitdata.data[field] = 0;
            }
        }

        function levelDetail() {
            if (submitdata.data.level_id) {
                level_details.value = levels.value.find((l) => l.id == submitdata.data.level_id);
            }
        }

        return {
            t, id,levels,nationalities, countries, cities,getCitiesByCountryId,level_details,levelDetail,
            loading, is_disabled, types,amounts,
            resetModal, empty, preview, resetModalHidden,
            imageUpload, image, ...toRefs(submitdata),
            v$, numberOfImage, requiredn, errors,getLevels,tracks,getMemorizationType,makeMaxNumber
        };
    },
    methods: {
        AddSubmit() {

            this.v$.$validate();
            this.errors = {};

            let formData = new FormData();

            formData.append('status', this.data.status ? 1 : 0);
            formData.append('name', this.data.name ?? '');
            formData.append('birth_date', this.data.birth_date ?? '');
            formData.append('level_id', this.data.level_id ?? '');
            formData.append('phone', this.data.phone ?? '');
            formData.append('id_number', this.data.id_number ?? '');
            formData.append('juz_count', this.data.juz_count ?? '');
            formData.append('guardian', this.data.guardian ?? '');
            formData.append('guardian_phone', this.data.guardian_phone ?? '');
            formData.append('preservation_method_id', this.data.preservation_method_id ?? '');
            formData.append('memorization_amount_id', this.data.memorization_amount_id ?? '');
            formData.append('track_id', this.data.track_id ?? '');
            formData.append('nationality_id', this.data.nationality_id ?? '');
            formData.append('country_id', this.data.country_id ?? '');
            formData.append('city_id', this.data.city_id ?? '');
            formData.append('gender', this.data.gender ?? '');
            if(this.data.password) {
                formData.append('password', this.data.password ?? '');
                formData.append('confirmation', this.data.confirmation ?? '');
            }


            if (this.image) {
                formData.append('image', this.image);
            }
            if (this.type !== 'edit') {
                if (!this.v$.$error) {
                    this.is_disabled = false;
                    this.loading = true;
                    adminApi.post(`dashboard/student`, formData)
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
                    }
                }
            } else if (!this.v$.$error) {
                this.is_disabled = false;
                this.loading = true;
                formData.append('_method', 'PUT');
                adminApi.post(`dashboard/student/${this.id}`, formData)
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
