<template>
    <div class="modal fade" id="show" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xll modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="adminModalLabel">
                        {{ $t('global.show') }}
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xxl-4 col-xl-12">
                            <div class="card custom-card overflow-hidden border border-primary">
                                <div class="card-body p-0">
                                    <div class="d-sm-flex align-items-top p-4 border-bottom-0 main-profile-cover">
                                        <div>
                                            <span class="avatar avatar-xxl avatar-rounded online me-3">
                                                <img :src="user.image" alt="">
                                            </span>
                                        </div>
                                        <div class="flex-fill main-profile-info">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h6 class="fw-semibold mb-1 text-fixed-white">{{user.name}}</h6>
                                            </div>
                                            <h4 class="fs-12 text-fixed-white mb-1 op-5">

                                                <span class="badge fs-12 rounded-pill bg-success" v-if="user.status == 1">{{ $t('global.activated') }}</span>
                                                <span class="badge fs-12 rounded-pill bg-warning" v-else-if="user.status == 2">{{ $t('global.pending') }}</span>
                                                <span class="badge fs-12 rounded-pill bg-danger" v-else>{{ $t('global.Inactive') }}</span>
                                            </h4>

                                            <p class="mb-1 text-white text-fixed-white op-7">
                                                <i
                                                    v-if="user.gender === 'male'"
                                                    class="bx bx-male-sign me-1 align-middle"
                                                    title="Male"
                                                ></i>
                                                <i
                                                    v-else-if="user.gender === 'female'"
                                                    class="bx bx-female-sign me-1 align-middle"
                                                    title="Female"
                                                ></i>
                                                <i
                                                    v-else
                                                    class="bx bx-user me-1 align-middle"
                                                    title="Other"
                                                ></i>
                                                {{$t('global.'+user.gender)}}
                                            </p>

                                            <div class="mb-4 text-white fs-14">
                                                <p> </p>
                                            </div>

                                            <div class="d-flex mb-0 mt-3">
                                                <div class="me-2 text-center">
                                                    <p class="fw-bold fs-20 text-fixed-white text-shadow mb-0">{{user.juz_count}}</p>
                                                    <p class="mb-0 fs-11 op-5 text-fixed-white">{{$t('global.juz_count')}}</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="p-4 border-bottom border-block-end-dashed">
                                        <p class="fs-15 mb-2 me-4 fw-semibold">{{ $t('global.ContactInformation') }} :</p>
                                        <div class="text-muted">

                                            <p class="mb-0">
                                                <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                                    <i class="bi bi-phone"></i>
                                                </span>
                                                {{user?.phone}} ({{user?.country?.phone_code}})
                                            </p>
                                            <p class="mb-0">
                                                <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                                    <i class="ri-mail-line"></i>
                                                </span>
                                                {{ user?.email }}
                                            </p>
                                            <p class="mb-0">
                                                <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                                    <i class="ri-map-pin-line align-middle fs-14"></i>
                                                </span>
                                                {{ user?.country?.name }} , {{ user?.city?.name }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="p-4 border-bottom border-block-end-dashed">
                                        <p class="fs-15 mb-2 me-4 fw-semibold">بيانات ولى الامر :</p>
                                        <div class="text-muted">

                                            <p class="mb-0">
                                                <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                                    <i class="ri-user-star-line" title="Parent"></i>
                                                </span>
                                                {{ user?.guardian }}
                                            </p>

                                            <p class="mb-0">
                                                <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                                    <i class="bi bi-phone"></i>
                                                </span>
                                                {{user?.guardian_phone}}
                                            </p>

                                        </div>
                                    </div>

                                    <div class="p-4 border-bottom border-block-end-dashed">
                                        <p class="fs-15 mb-2 me-4 fw-semibold">{{ $t('global.Student data') }} :</p>
                                        <div class="card-body pt-0">
                                            <ul class="list-group">

                                                <li class="list-group-item">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div class="me-2 fw-semibold">
                                                            {{ $t('global.memorizationAmount') }} :
                                                        </div>
                                                        <span class="fs-12 text-muted">{{user?.memorization_amount?.name}}</span>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div class="me-2 fw-semibold">
                                                            {{ $t('global.track') }} :
                                                        </div>
                                                        <span class="fs-12 text-muted">{{user?.track?.name}}</span>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div class="me-2 fw-semibold">
                                                            {{ $t('global.memorizationType') }} :
                                                        </div>
                                                        <span class="fs-12 text-muted">{{user?.preservation_method?.name}}</span>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div class="me-2 fw-semibold">
                                                            {{ $t('global.level') }} :
                                                        </div>
                                                        <span class="fs-12 text-muted">{{user?.level?.name}}</span>
                                                    </div>
                                                </li>

                                                <li class="list-group-item">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div class="me-2 fw-semibold">
                                                            {{ $t('global.nationality') }} :
                                                        </div>
                                                        <span class="fs-12 text-muted">{{user?.nationality?.name}}</span>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div class="me-2 fw-semibold">
                                                            {{ $t('global.id_number') }} :
                                                        </div>
                                                        <span class="fs-12 text-muted">{{user.id_number}}</span>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div class="me-2 fw-semibold">
                                                            {{ $t('global.birth_date') }} :
                                                        </div>
                                                        <span class="fs-12 text-muted">{{user.birth_date}}</span>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div class="me-2 fw-semibold">
                                                            {{ $t('global.age') }} :
                                                        </div>
                                                        <span class="fs-12 text-muted">{{user.age}} {{ $t('global.year') }}</span>
                                                    </div>
                                                </li>

                                                <li class="list-group-item">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div class="me-2 fw-semibold">
                                                            {{ $t('global.created_at') }} :
                                                        </div>
                                                        <span class="fs-12 text-muted">{{user.created_at}}</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-8 col-xl-12">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card custom-card">
                                        <div class="card-body p-0">
                                            <div class="p-3 border-bottom border-block-end-dashed d-flex align-items-center justify-content-between">
                                                <div>
                                                    <ul class="nav nav-tabs mb-0 tab-style-6 justify-content-start" id="myTab" role="tablist">
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link active" id="gallery-tab" data-bs-toggle="tab"
                                                                    data-bs-target="#gallery-tab-pane" type="button" role="tab"
                                                                    aria-controls="gallery-tab-pane" aria-selected="false">
                                                                <i class="ri-group-line me-1 align-middle d-inline-block"></i>
                                                                {{$t('global.circles')}}
                                                            </button>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link" id="posts-tab" data-bs-toggle="tab"
                                                                    data-bs-target="#posts-tab-pane" type="button" role="tab"
                                                                    aria-controls="posts-tab-pane" aria-selected="false"><i
                                                                class="ri-book-line me-1 align-middle d-inline-block"></i>{{$t('global.StudentExams')}}</button>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link" id="activity-tab" data-bs-toggle="tab"
                                                                data-bs-target="#activity-tab-pane" type="button" role="tab"
                                                                aria-controls="activity-tab-pane" aria-selected="true">
                                                                <i class="ri-award-fill me-1 align-middle d-inline-block"></i>
                                                                {{$t('global.certificates')}}
                                                             </button>
                                                        </li>
                                                         <li class="nav-item" role="presentation">
                                                            <button class="nav-link" id="digital_badge" data-bs-toggle="tab"
                                                                    data-bs-target="#digital_badge-pane" type="button" role="tab"
                                                                    aria-controls="digital_badge-pane" aria-selected="false">
                                                                    <i class="ri-medal-2-line me-1 align-middle d-inline-block"></i>
                                                                    {{$t('global.studentDigitalBadges')}}
                                                                </button>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="p-3" style="background-color: #f1f1f1;">
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane show active fade p-0 border-0" id="gallery-tab-pane" role="tabpanel" aria-labelledby="gallery-tab" tabindex="0">

                                                       <div class="row">
                                                            <loader v-if="loading" />
                                                            <div class="table-responsive mb-2">
                                                                <table class="table text-nowrap table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">{{ $t('global.title') }}</th>
                                                                        <th scope="col">{{ $t('global.circleType') }}</th>
                                                                        <th scope="col">{{ $t('global.StudentType') }}</th>
                                                                        <th scope="col">{{ $t('global.teacher') }}</th>
                                                                        <th scope="col">{{ $t('global.day') }}</th>
                                                                        <th scope="col">{{ $t('global.start_time') }}</th>
                                                                        <th scope="col">{{ $t('global.end_time') }}</th>
                                                                        <th scope="col">{{ $t('global.status') }}</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody v-if="user?.circles && user?.circles.length">
                                                                    <tr v-for="(item,index) in user?.circles" :key="item.id">
                                                                        <td scope="row">{{index + 1}}</td>
                                                                        <td>{{item.name}}</td>
                                                                        <td>{{item.circle_type?.name}}</td>
                                                                        <td>{{$t('global.'+item.gender)}}</td>
                                                                        <td>{{item.teacher_name}}</td>
                                                                        <td>
                                                                            <span v-for="dur in item?.duration" :key="dur.id">{{$t('global.'+dur.day)}} <br></span>
                                                                        </td>
                                                                        <td>
                                                                            <span v-for="dur in item?.duration" :key="dur.id">{{dur.start_time}} <br></span>
                                                                        </td>
                                                                        <td>
                                                                            <span v-for="dur in item?.duration" :key="dur.id">{{dur.end_time}} <br></span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="badge rounded-pill bg-success-transparent"
                                                                                v-if="item.status">{{ $t('global.activated') }}</span>
                                                                            <span class="badge rounded-pill bg-danger-transparent" v-else>{{
                                                                                $t('global.Inactive') }}</span>

                                                                        </td>
                                                                    </tr>

                                                                    </tbody>

                                                                    <tbody v-else>
                                                                    <tr>
                                                                        <th class="text-center" colspan="9">{{ $t('global.NoDataFound') }}</th>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade p-0 border-0" id="posts-tab-pane" role="tabpanel" aria-labelledby="posts-tab" tabindex="0">
                                                        <div class="row">
                                                             <div class="table-responsive mb-2">
                                                                <table class="table text-nowrap table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">{{ $t('global.track') }}</th>
                                                                        <th scope="col">{{ $t('global.Supervisor') }}</th>
                                                                        <th scope="col">{{ $t('global.examTime') }}</th>
                                                                        <th scope="col">{{ $t('global.examLink') }}</th>
                                                                        <th scope="col">{{ $t('global.degree') }}</th>
                                                                        <th scope="col">{{ $t('global.status') }}</th>
                                                                        <th scope="col">{{ $t('global.created_at') }}</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody v-if="user?.exams && user?.exams.length">
                                                                        <tr v-for="(item,index) in user?.exams" :key="item.id">
                                                                            <td scope="row">{{index + 1}}</td>
                                                                            <td>{{ item.track?.name }}</td>
                                                                            <td>{{ item.admin }}</td>
                                                                            <td>{{ item.date_time }}</td>
                                                                            <td v-if="item.exam_link" dir="ltr"> <a :href="item.exam_link" target="_blank">{{ truncateString(item.exam_link,25) }}</a></td>
                                                                            <td v-else>---</td>
                                                                            <td>{{ item.degree }}</td>
                                                                            <td>
                                                                                <span style="font-size:13px" :class="`badge rounded-pill bg-${item.status?.color}-transparent`">
                                                                                    <i :class="[item.status?.icon, 'text-dark']"></i> {{ item.status?.label }}
                                                                                </span>
                                                                            </td>
                                                                            <td>{{item.created_at}}</td>
                                                                        </tr>

                                                                    </tbody>

                                                                    <tbody v-else>
                                                                        <tr>
                                                                            <th class="text-center" colspan="8">{{ $t('global.NoDataFound') }}</th>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade p-0 border-0" id="activity-tab-pane" role="tabpanel" aria-labelledby="activity-tab" tabindex="0">
                                                        <div class="row">

                                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 task-card" v-for="(item,index) in user?.certificates" :key="item.id">
                                                                <div class="card custom-card task-pending-card">
                                                                    <img :src="item?.image" class="card-img-top" style="height: 200px;" alt="...">
                                                                    <div class="card-body">
                                                                        <h6 class="card-title fw-semibold">{{item?.title}}</h6>

                                                                        <p class="badge rounded-pill bg-success-transparent">{{item?.created_at}}</p>
                                                                    </div>
                                                                    <div class="card-footer">
                                                                        <a :href="item?.image" :download="item?.image" class="btn btn-primary d-flex align-items-center justify-content-center">
                                                                            <i class="ri-download-line fs-16 align-middle me-1"></i>{{ $t('global.downloadFile') }}
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade p-0 border-0" id="digital_badge-pane" role="tabpanel" aria-labelledby="digital_badge" tabindex="0">
                                                        <div class="row">
                                                             <div class="table-responsive mb-2">
                                                                <table class="table text-nowrap table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">{{ $t('label.image') }}</th>
                                                                        <th scope="col">{{ $t('label.title') }}</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody v-if="user?.digitalBadges && user?.digitalBadges.length">
                                                                        <tr v-for="(item,index) in user?.digitalBadges" :key="item.id">
                                                                            <td scope="row">{{index + 1}}</td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="me-3">
                                                                                        <span class="avatar avatar-lg bg-light">
                                                                                            <img :src="item.image" alt="" style="width: 100%; height: 100%">
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>{{item.name}}</td>
                                                                        </tr>

                                                                    </tbody>

                                                                    <tbody v-else>
                                                                        <tr>
                                                                            <th class="text-center" colspan="3">{{ $t('global.NoDataFound') }}</th>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { $t } from "@primevue/themes";
import { ref } from "vue";
import { useI18n } from "vue-i18n";
import adminApi from "../../../api/adminAxios";

export default {
    name: "Show",
    props: {
        dataRow: { default: '' },
        type: { default: 'order' },
    },
    data() {
        return {
            errors: {}
        }
    },
    setup(props) {
        setTimeout(async () => {
            let myModalEl = document.getElementById('show')
            myModalEl.addEventListener('show.bs.modal', function (event) {
                resetModal();
            })
            myModalEl.addEventListener('hidden.bs.modal', function (event) {

            })
        }, 150);
        let loading = ref(false);
        const { t } = useI18n({});
        const id = ref(null);
        const user = ref('');
        let circles = ref([]);

        function defaultData() {
            user.value = '';
            id.value = null;
        }

        function resetModal() {
            defaultData();
            setTimeout(async () => {
                id.value = props.dataRow.id;
                adminApi.get(`dashboard/student/${props.dataRow.id}`)
                .then((res) => {
                    let l = res.data.data;
                    user.value = l;
                    circles.value = l.circles;
                    console.log(l);

                })
                .catch((err) => {
                    console.log(err);
                })
            }, 50);
        }

        let truncateString = (str, maxLength) => {
            if (str.length > maxLength) {
                return str.slice(0, maxLength) + '...';
            }
            return str;
        }

        return {t, id, loading,user,circles,truncateString};
    },
    methods:{

    }
}
</script>

<style scoped>
.work {
    padding: 10px 10px;
    background: #d5d5d5;
    border-radius: 13px;
    margin: 0 1px;
}
</style>
