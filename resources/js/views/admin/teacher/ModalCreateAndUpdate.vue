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
                            <label class="form-label">{{ $t('global.email') }}</label>
                            <input type="email" class="form-control" v-model.trim="v$.email.$model"
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

                         <div class="col-md-6 mt-3">
                            <label class="form-label">{{ $t('global.hourly_wage') }}</label>
                            <input type="number" step="any" class="form-control" v-model="v$.salary.$model"
                                 :class="{
                                    'is-invalid': v$.salary.$error || errors[`salary`],
                                    'is-valid': !v$.salary.$invalid && !errors[`salary`]
                                }">

                            <div class="invalid-feedback">
                                <span v-if="v$.salary.required.$invalid">{{ $t('validation.fieldRequired') }}<br />
                                </span>
                                 <span v-if="v$.experience_years.numeric.$invalid">{{$t('validation.ThisFieldIsNumeric')}} <br /></span>

                            </div>
                            <template v-if="errors[`salary`]">
                                <error-message v-for="(errorMessage, index) in errors[`salary`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label class="form-label">{{ $t('global.juz_count') }}</label>
                            <input type="number" class="form-control" @input="makeMaxNumber('juz_count',30)" v-model="v$.juz_count.$model"
                                 :class="{
                                    'is-invalid': v$.juz_count.$error || errors[`juz_count`],
                                    'is-valid': !v$.juz_count.$invalid && !errors[`juz_count`]
                                }">

                            <div class="invalid-feedback">
                                <span v-if="v$.juz_count.required.$invalid">{{ $t('validation.fieldRequired') }}<br />
                                </span>
                                 <span v-if="v$.experience_years.numeric.$invalid">{{$t('validation.ThisFieldIsNumeric')}} <br /></span>

                            </div>
                            <template v-if="errors[`juz_count`]">
                                <error-message v-for="(errorMessage, index) in errors[`juz_count`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label class="form-label">{{ $t('global.experience_years') }}</label>
                            <input type="number" class="form-control" @input="makeMaxNumber('experience_years',40)" v-model="v$.experience_years.$model"
                                 :class="{
                                    'is-invalid': v$.experience_years.$error || errors[`experience_years`],
                                    'is-valid': !v$.experience_years.$invalid && !errors[`experience_years`]
                                }">

                            <div class="invalid-feedback">
                                <span v-if="v$.experience_years.required.$invalid">{{ $t('validation.fieldRequired') }}<br />
                                </span>
                                <span v-if="v$.experience_years.numeric.$invalid">{{$t('validation.ThisFieldIsNumeric')}} <br /></span>

                            </div>
                            <template v-if="errors[`experience_years`]">
                                <error-message v-for="(errorMessage, index) in errors[`experience_years`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label class="form-label">{{ $t('global.Quran_licenses') }}</label>
                            <input type="number" class="form-control" @input="makeMaxNumber('Quran_licenses',15)" v-model="v$.Quran_licenses.$model"
                                 :class="{
                                    'is-invalid': v$.Quran_licenses.$error || errors[`Quran_licenses`],
                                    'is-valid': !v$.Quran_licenses.$invalid && !errors[`Quran_licenses`]
                                }">

                            <div class="invalid-feedback">
                                <span v-if="v$.Quran_licenses.required.$invalid">{{ $t('validation.fieldRequired') }}<br />
                                </span>
                                <span v-if="v$.Quran_licenses.numeric.$invalid">{{$t('validation.ThisFieldIsNumeric')}} <br /></span>

                            </div>
                            <template v-if="errors[`Quran_licenses`]">
                                <error-message v-for="(errorMessage, index) in errors[`Quran_licenses`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
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

                        <div class="col-md-12" style="padding: 20px; margin-bottom: 20px">
                            <!-- <div class="card p-2 bg-light border border-info text-center align-items-center mx-3">
                                <h5 class="card-title p-0 m-0">{{ $t("global.images") }}</h5>
                            </div> -->
                            <div class="row px-5">

                                 <div class="col-md-6 mt-3 row flex-fill">
                                    <label class="form-label fs-14 text-center">{{$t("global.profile picture")}}</label>
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
                                                    <img class="img-fluid rounded"  style="max-width: 150px; height: 150px" :src="`${imageUpload}`">
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
                                  <!-- Profile Image -->
                                <div class="col-md-6 mt-3 row flex-fill">
                                    <label class="form-label fs-14 text-center">
                                        {{ $t('global.cv') }}
                                    </label>

                                    <div class="btn btn-outline-light waves-effect" style="width: 90%; height: 90%">
                                        <!-- Upload Placeholder -->
                                        <span v-if="!showProfile" style="margin-top: 30%; width: 90%; height: 90%">
                                            {{ $t('global.You can add images or PDF files for the teachers CV') }}
                                            <br />
                                            <i class="bi bi-cloud-upload fs-40"></i>
                                            <i class="fas fa-cloud-upload-alt ml-3" aria-hidden="true"></i>
                                        </span>

                                        <!-- Preview Section -->
                                        <div id="profile-image-container">
                                            <figure>
                                                <figcaption>
                                                    <!-- Display Image Preview if it's NOT a PDF -->
                                                    <img v-if="showProfile && !isPDF && !profileImagePreview.endsWith('.pdf')" class="img-fluid rounded"
                                                        style="max-width: 150px; height: 150px" :src="profileImagePreview" />

                                                    <!-- Display PDF Preview -->
                                                    <div v-else-if="showProfile && (isPDF || profileImagePreview.endsWith('.pdf'))" class="text-center">
                                                        <i class="bi bi-file-earmark-pdf text-danger"
                                                            style="font-size: 120px; width: 170px; height: 170px; cursor: pointer;"
                                                            ></i>
                                                        <p class="mt-2">
                                                            <a :href="profileImagePreview" target="_blank" >
                                                                {{ pdfFileName || profileImagePreview.split('/').pop() }}
                                                            </a>
                                                        </p>
                                                    </div>
                                                </figcaption>
                                            </figure>
                                        </div>

                                        <!-- File Input -->
                                        <input name="profile_image" type="file" @change="previewProfileImage" id="profileImage"
                                            accept="image/*,application/pdf">

                                        <!-- Error Messages -->
                                        <template v-if="errors['profile_image'] && !showProfile">
                                            <error-message v-for="(errorMessage, index) in errors['profile_image']"
                                                :key="index">
                                                {{ errorMessage }}
                                            </error-message>
                                        </template>
                                    </div>
                                </div>

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
import { maxLength, minLength, required, sameAs,email, alphaNum, requiredIf,numeric } from "@vuelidate/validators";
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

        let nationalities = ref([]);
        let countries = ref([]);
        let cities = ref([]);
        let tracks = ref([]);

         onMounted(async ()=>{
            flatpickr("#date", {});
        })


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

        function defaultData() {
            submitdata.data.status = true;
            submitdata.data.name = '';
            submitdata.data.id_number = '';
            submitdata.data.phone = '';
            submitdata.data.email = '';
            submitdata.data.nationality_id = 2;
            submitdata.data.birth_date = '';
            submitdata.data.country_id = '';
            submitdata.data.city_id = '';
            submitdata.data.gender = 'male';
            submitdata.data.password = '';
            submitdata.data.confirmation = '';
            submitdata.data.juz_count = '';
            submitdata.data.experience_years = '';
            submitdata.data.Quran_licenses = '';
            submitdata.data.salary = '';
            submitdata.data.cv = "";
            imageUpload.value = '';
            is_disabled.value = false;
            image.value = null
            errors.value = [];
            profileImage.value = "";
            profileImagePreview.value = {};
            empty();
        }
        function resetModal() {
            defaultData();
            setTimeout(async () => {

                getNationalities();
                getCountries();
                if (props.type != 'edit') {
                } else {
                    id.value = props.dataRow.id;
                    submitdata.data.name = props.dataRow.name;
                    submitdata.data.phone = props.dataRow.phone;
                    submitdata.data.email = props.dataRow.email;
                    submitdata.data.id_number = props.dataRow.id_number;
                    submitdata.data.nationality_id = props.dataRow.nationality_id;
                    submitdata.data.track_id = props.dataRow.track_id;
                    submitdata.data.country_id = props.dataRow.country_id;
                    submitdata.data.gender = props.dataRow.gender;
                    submitdata.data.status = props.dataRow.status == 1;
                    submitdata.data.birth_date = props.dataRow.birth_date;
                    submitdata.data.juz_count = props.dataRow.juz_count;
                    submitdata.data.experience_years = props.dataRow.experience_years;
                    submitdata.data.Quran_licenses = props.dataRow.Quran_licenses;
                    submitdata.data.salary = props.dataRow.salary;
                    imageUpload.value = props.dataRow.image;
                    profileImagePreview.value = props.dataRow.cv;
                    if (props.dataRow.cv) {
                        showProfile.value = true;
                        isPDF.value = props.dataRow.cv.endsWith('.pdf');
                    } else {
                        showProfile.value = false;
                    }
                    if (submitdata.data.country_id) {
                        getCitiesByCountryId();
                        submitdata.data.city_id = props.dataRow.city_id;
                    }

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
                phone: '',
                email: '',
                nationality_id: 2,
                country_id: '',
                city_id: '',
                gender: 'male',
                id_number: '',
                password: '',
                confirmation: '',
                birth_date: '',
                juz_count: '',
                experience_years: '',
                Quran_licenses: '',
                salary: '',
                cv: '',
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

            profileImagePreview.value = "";
            showProfile.value = false;
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

        const showProfile = ref(false);
        const profileImagePreview = ref({});
        const isPDF = ref(false);
        const pdfFileName = ref("");

        const rules = computed(() => {
            return {
                name: {
                    minLength: minLength(3),
                    maxLength: maxLength(100),
                    required
                },
                id_number: {
                    required
                },
                 phone: {
                    required,
                    minLength: minLength(10),
                    maxLength: maxLength(20)
                },
                 email: {
                    email,
                    required
                },
                 birth_date: {
                    required
                },
                juz_count: {
                    required,numeric
                },
                experience_years: {
                    required,numeric
                },
                Quran_licenses: {
                    required,numeric
                },
                salary: {
                    required,numeric
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

        return {
            t, id,nationalities, countries, cities,getCitiesByCountryId,makeMaxNumber,
            loading, is_disabled,
            resetModal, empty, preview, resetModalHidden,
            imageUpload, image, ...toRefs(submitdata),
            v$, numberOfImage, requiredn, errors,tracks,showProfile,profileImagePreview, isPDF, pdfFileName,
        };
    },
    methods: {
         previewProfileImage(event) {
            const file = event.target.files[0];

            if (file) {
                this.profileImage = file;

                // Check if it's an image
                if (file.type.includes("image")) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.profileImagePreview = e.target.result;
                        this.isPDF = false; // Not a PDF
                        this.showProfile = true;
                    };
                    reader.readAsDataURL(file);
                }
                // Check if it's a PDF
                else if (file.type === "application/pdf") {
                    this.profileImagePreview = URL.createObjectURL(file); // Create URL for the PDF
                    this.pdfFileName = file.name; // Save the PDF file name
                    this.isPDF = true; // Set PDF flag
                    this.showProfile = true;
                }
            }
        },
        AddSubmit() {

            this.v$.$validate();
            this.errors = {};

            let formData = new FormData();

            formData.append('status', this.data.status ? 1 : 0);
            formData.append('name', this.data.name ?? '');
            formData.append('id_number', this.data.id_number ?? '');
            formData.append('birth_date', this.data.birth_date ?? '');
            formData.append('email', this.data.email ?? '');
            formData.append('phone', this.data.phone ?? '');
            formData.append('nationality_id', this.data.nationality_id ?? 2);
            formData.append('country_id', this.data.country_id ?? '');
            formData.append('city_id', this.data.city_id ?? '');
            formData.append('gender', this.data.gender ?? '');
            formData.append('juz_count', this.data.juz_count ?? '');
            formData.append('experience_years', this.data.experience_years ?? '');
            formData.append('Quran_licenses', this.data.Quran_licenses ?? '');
            formData.append('salary', this.data.salary ?? '');
             if (this.profileImage) {
                formData.append("cv", this.profileImage);
            }
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
                    adminApi.post(`dashboard/teacher`, formData)
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
                        // this.requiredn = true;
                    }
                }
            } else if (!this.v$.$error) {
                this.is_disabled = false;
                this.loading = true;
                formData.append('_method', 'PUT');
                adminApi.post(`dashboard/teacher/${this.id}`, formData)
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
    color: #4b9f18;
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
