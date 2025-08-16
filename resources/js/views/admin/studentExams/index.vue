<template>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">{{ $t('global.studentExams') }}</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><router-link :to="{ name: 'dashboard' }">{{ $t('global.home')
                                }}</router-link></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $t('global.studentExams') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header Close -->
        <!-- Start:: data table -->
        <div class="row">
            <div class="col-xl-12">
                <loader v-if="loading" />
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <search-and-filters @search="(val) => search.searchKey = val" />

                        <div class="prism-toggle">

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mb-2">
                            <table class="table text-nowrap table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ $t('global.Three-part name') }}</th>
                                        <th scope="col">{{ $t('global.track') }}</th>
                                        <th scope="col">{{ $t('global.Supervisor') }}</th>
                                        <th scope="col">{{ $t('global.examTime') }}</th>
                                        <th scope="col">{{ $t('global.examLink') }}</th>
                                        <th scope="col">{{ $t('global.degree') }}</th>
                                        <th scope="col">{{ $t('global.status') }}</th>
                                        <th scope="col">{{ $t('global.created_at') }}</th>
                                        <th scope="col">{{ $t('global.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody v-if="data && data.length">
                                    <tr v-for="(item, index) in data" :key="item.id">
                                        <td scope="row">{{ item.student?.code }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <span :class="['avatar avatar-xl me-3 avatar-rounded', parseInt(item.status) === 1 ? 'online' : 'offline']">
                                                        <img :src="item.student?.image" alt="">
                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="mb-2 fs-14 fw-semibold">
                                                        <a href="javascript:void(0);">{{item.student?.name}}</a>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span class="text-muted d-block">{{item.student?.phone}} ({{item.student?.phone_code}})</span>
                                                        <span class="text-muted">{{$t('global.'+item.student?.gender)}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
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
                                        <td>
                                            <div class="hstack gap-2 fs-15" v-if="parseInt(item.degree) === 0">

                                                <button v-if="permission.includes('add degree to exam')" 
                                                    @click.prevent="showEditMode(item)" data-bs-toggle="modal"
                                                    data-bs-target="#add-circle-modal"
                                                    class="btn btn-icon btn-sm btn-primary-transparent rounded-pill"
                                                    :title="$t('role_and_permissions.add degree to exam')">
                                                    <i class="ri-add-circle-line"></i>
                                                </button>

                                                <button v-if="permission.includes('add time to exam')"
                                                    @click.prevent="showAdminMode(item)"
                                                    data-bs-toggle="modal" data-bs-target="#add-admin-modal"
                                                        class="btn btn-icon btn-sm btn-success-transparent rounded-pill"
                                                        :title="$t('role_and_permissions.add time to exam')">
                                                     <i class="ri-time-line"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <th class="text-center" colspan="10">{{ $t('global.NoDataFound') }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :limit="2" :data="dataPaginate" @pagination-change-page="getData">
                            <template #prev-nav>
                                <span>&lt; {{ $t('global.Previous') }}</span>
                            </template>
                            <template #next-nav>
                                <span>{{ $t('global.Next') }} &gt;</span>
                            </template>
                        </Pagination>
                    </div>
                </div>
            </div>
        </div>
        <!-- End:: data table -->
        <AddDegreeToExam v-model="modalShow" :type="type" :dataRow="dataRow" @created="getData(pagePaginate)" />
        <AddAdmin v-model="showAddAdmin" :dataRow="dataRow" @created="getData(pagePaginate)" />
    </div>
</template>

<script>
import { onBeforeMount, inject, ref } from "vue";
import crud from "../../../composable/crud_structure";
import AddDegreeToExam from "./addDegreeToExam.vue"
import AddAdmin from "./addAdmin.vue"

export default {
    name: "index",
    components: {
        AddDegreeToExam, AddAdmin
    },
    setup() {
        const emitter = inject('emitter');
        const selectedUser = ref({});
        let showAddAdmin = ref(false);

        const { getData, loading, data, dataPaginate, permission, uri, showModelCreate, showEditMode, showModelReason, deleteData, search, type, dataRow, modalShow, reasonShow ,pagePaginate,truncateString} = crud();

        search.value = {
            searchKey: '',
            searchInTranslations: false,
            columns: ['name'],
            searchInRelations: [
                {
                    relation: 'student',
                    columns: ['id', 'name', 'phone','gender','code'],
                    searchInRelationTranslations: false
                },
                {
                    relation: 'admin',
                    columns: ['name'],
                    searchInRelationTranslations: false
                },
                {
                    relation: 'track',
                    columns: ['name'],
                    searchInRelationTranslations: false
                },

            ]
        }

        onBeforeMount(() => {
            uri.value = 'exams';
            getData();
        });

        let showAdminMode = (row) => {
            dataRow.value=row;
            type.value='edit';
            showAddAdmin.value=true;
        }


        return { getData, loading, search, permission, deleteData, showEditMode, showModelCreate, showModelReason, data, dataPaginate, type, dataRow, modalShow, reasonShow, selectedUser ,pagePaginate,showAdminMode,showAddAdmin,truncateString};

    }
}
</script>
