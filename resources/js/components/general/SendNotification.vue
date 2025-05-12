<template>
    <div class="modal fade" id="send-notification" tabindex="-1" aria-labelledby="sendNotificationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="sendNotificationModalLabel">
                        {{ selectedUser == 'all' ? $t('global.send_notification_to_all') :
                            ($t('global.send_notification_to') + ' ' + selectedUser.name) }}
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card custom-card">

                        <div class="card-body">
                            <loader v-if="loading" />
                            <div class="row">
                                <div class="col-md-6" v-if="data.ar" v-for="lang in languages">
                                    <div class="row">
                                        <div class="col-md-12 mt-3">
                                            <label class="form-label">{{ $t('label.title') }} ({{ lang.title }})</label>
                                            <input type="text" class="form-control" v-model="v$[lang.code].title.$model"
                                                :placeholder="$t('label.title') + ' ' + lang.title" :class="{
                                                    'is-invalid': v$[lang.code].title.$error || errors[`title_${lang.code}`],
                                                    'is-valid': !v$[lang.code].title.$invalid && !errors[`title_${lang.code}`]
                                                }">

                                            <div class="invalid-feedback">
                                                <span v-if="v$[lang.code].title.required.$invalid">{{
                                                    $t('validation.fieldRequired')
                                                    }}<br /> </span>
                                                <span v-if="v$[lang.code].title.minLength.$invalid">{{
                                                    $t('validation.TitleIsMustHaveAtLeast') }} {{
                                                        v$[lang.code].title.minLength.$params.min
                                                    }} {{ $t('validation.Letters') }} <br />
                                                </span>
                                                <span v-if="v$[lang.code].title.maxLength.$invalid">{{
                                                    $t('validation.TitleIsMustHaveAtMost') }} {{
                                                        v$[lang.code].title.maxLength.$params.max
                                                    }} {{ $t('validation.Letters') }}
                                                </span>
                                            </div>
                                            <template v-if="errors[`title_${lang.code}`]">
                                                <error-message v-for="(errorMessage, index) in errors[`title_${lang.code}`]"
                                                    :key="index">
                                                    {{ errorMessage }}
                                                </error-message>
                                            </template>
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <label class="form-label">{{ $t('global.message') }} ({{ lang.title }})</label>
                                            <textarea class="form-control summernote" rows="6"
                                                v-model.trim="v$[lang.code].message.$model" :class="{
                                                    'is-invalid': v$[lang.code].message.$error || errors[`message_${lang.code}`],
                                                    'is-valid': !v$[lang.code].message.$invalid && !errors[`message_${lang.code}`]
                                                }">
                                            </textarea>
                                            <div class="invalid-feedback">
                                                <span v-if="v$[lang.code].message.required.$invalid">{{
                                                    $t('validation.fieldRequired') }}<br /> </span>
                                            </div>
                                            <template v-if="errors[`message_${lang.code}`]">
                                                <error-message v-for="(errorMessage, index) in errors[`message_${lang.code}`]"
                                                    :key="index">
                                                    {{ errorMessage }}
                                                </error-message>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label class="form-label">{{ $t('label.endDate') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i>
                                        </div>
                                        <input type="text" class="form-control" id="datetime"
                                            :placeholder="$t('label.endDate')" v-model.trim="v$.expire_date.$model"
                                            :class="{
                                                'is-invalid': v$.expire_date.$error || errors[`expire_date`],
                                                'is-valid': !v$.expire_date.$invalid && !errors[`expire_date`]
                                            }">
                                    </div>

                                    <template v-if="errors['expire_date']">
                                        <error-message v-for="(errorMessage, index) in errors['expire_date']"
                                            :key="index">
                                            {{ errorMessage }}
                                        </error-message>
                                    </template>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" v-if="!loading" @click.prevent="AddSubmit" class="btn btn-primary">{{
                        $t('global.Submit') }}</button>

                    <button class="btn btn-primary btn-loader" v-else>
                        <span class="me-2">{{ $t('global.Loading') }}</span>
                        <span class="loading"><i class="ri-loader-2-fill fs-16"></i></span>
                    </button>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import { reactive, computed, ref, toRefs, nextTick, onMounted } from 'vue';
import { maxLength, minLength, required } from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import adminApi from "../../api/adminAxios";
import { useI18n } from "vue-i18n";

export default {
    name: "SendNotification",
    props: {
        type: { default: '' },
        selectedUser: { default: '' },
        url: { default: 'dashboard/send-notification' },
    },
    setup(props) {
        setTimeout(async () => {
            let myModalEl = document.getElementById('send-notification')
            myModalEl.addEventListener('show.bs.modal', function (event) {
                resetModal();
                flatpickr("#datetime", {
                    enableTime: true,
                    dateFormat: "Y-m-d",
                });
            })
            myModalEl.addEventListener('hidden.bs.modal', function (event) {
                resetModalHidden();
            })
        }, 150);

        const errors = ref([]);
        const languages = ref([]);
        const langValidation = ref({});
        const { t } = useI18n();

        let loading = ref(false);

        onMounted(() => {
            languages.value = JSON.parse(localStorage.getItem('languages'));
            // languages.value = lang.filter((el) => el.code == 'en' || el.code == 'ar');
        });


        function defaultData() {

            languages.value.forEach((el) => {
                submitdata.data[el.code] = { title: '', message: '' };
                langValidation.value[el.code] = {
                    title: { minLength: minLength(3), maxLength: maxLength(40), required, },
                    message: { required }
                }
            });
            loading.value = false;
            errors.value = [];
        }

        function resetModal() {
            defaultData();
        }
        function resetModalHidden() {
            defaultData();
            nextTick(() => { v$.value.$reset() });
        }

        let submitdata = reactive({
            data: {
                expire_date: '',
            }
        });

        const rules = computed(() => {
            return {
                ...langValidation.value,
                expire_date: {},
            }
        });

        const v$ = useVuelidate(rules, submitdata.data);

        return {
            t, loading, languages,
            resetModal, resetModalHidden
            , ...toRefs(submitdata),
            v$, errors
        };
    },
    methods: {
        AddSubmit() {

            this.v$.$validate();
            this.errors = {};

            let formData = new FormData();
            this.languages.forEach((el) => {
                formData.append(`title[${el.code}]`, this.data[el.code].title);
                formData.append(`message[${el.code}]`, this.data[el.code].message);
            })
            formData.append('type', this.type);
            formData.append('expire_date', this.data.expire_date);
            formData.append('to', this.selectedUser == 'all' ? this.selectedUser : this.selectedUser.id);

            if (!this.v$.$error) {
                this.loading = true;
                adminApi.post(`${this.url}`, formData)
                    .then((res) => {
                        Swal.fire({
                            icon: 'success',
                            title: `${this.t('global.SentSuccessfully')}`,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    })
                    .catch((err) => {
                        this.errors = err.response.data.errors;
                        this.loading = false;

                    })
                    .finally(() => {
                        this.loading = false;
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
