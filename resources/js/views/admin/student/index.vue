<template>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">{{ $t('global.students') }}</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><router-link :to="{ name: 'dashboard' }">{{ $t('global.home')
                                }}</router-link></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $t('global.students') }}</li>
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
                            <button v-if="permission.includes('student create')" @click="showModelCreate"
                                class="btn btn-sm btn-primary-light" data-bs-toggle="modal"
                                data-bs-target="#admin-modal">
                                <i class="ri-add-line me-1 fw-semibold align-middle"></i>{{ $t('global.add') }}
                            </button>

                            <button @click="selectedUser = 'all'" data-bs-toggle="modal"
                                v-if="permission.includes('student send notification')"
                                data-bs-target="#send-notification" :title="$t('global.send_notification')"
                                class="btn btn-sm btn-warning-light ms-3"><i class="bx bx-bell header-link-icon"></i>
                                {{ $t('global.send_notification_to_all') }} </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mb-2">
                            <table class="table text-nowrap table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ $t('global.Three-part name') }}</th>
                                        <th scope="col">{{ $t('global.nationality') }}</th>
                                        <th scope="col">{{ $t('global.country') }}</th>
                                        <th scope="col">{{ $t('global.level') }}</th>
                                        <th scope="col">{{ $t('global.status') }}</th>
                                        <th scope="col">{{ $t('global.created_at') }}</th>
                                        <th scope="col">{{ $t('global.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody v-if="data && data.length">
                                    <tr v-for="(item, index) in data" :key="item.id">
                                        <td scope="row">{{ index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <span :class="['avatar avatar-xl me-3 avatar-rounded', parseInt(item.status) === 1 ? 'online' : 'offline']">
                                                        <img :src="item.image" alt="">
                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="mb-2 fs-14 fw-semibold">
                                                        <a href="javascript:void(0);">{{item.name}}</a>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span class="text-muted d-block">{{item.phone}} ({{item.country?.phone_code}})</span>
                                                        <span class="text-muted">{{$t('global.'+item.gender)}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ item.nationality?.name }}</td>
                                        <td>{{ item.country?.name }}</td>
                                        <td>{{ item.level?.name }}</td>
                                        <td>
                                            <span class="badge rounded-pill bg-success-transparent"
                                                v-if="item.status">{{ $t('global.activated') }}</span>
                                            <span class="badge rounded-pill bg-danger-transparent" v-else>{{
                                                $t('global.Inactive') }}</span>
                                        </td>
                                        <td>{{item.created_at}}</td>
                                        <td>
                                            <div class="hstack gap-2 fs-15">
                                                <a @click="selectedUser = item" data-bs-toggle="modal"
                                                    v-if="permission.includes('student send notification')"
                                                    data-bs-target="#send-notification"
                                                    :title="$t('global.send_notification')"
                                                    class="btn btn-icon btn-sm btn-warning-transparent rounded-pill"><i
                                                        class="bx bx-bell header-link-icon"></i></a>

                                                <button v-if="permission.includes('student edit')"
                                                    @click.prevent="showEditMode(item)" data-bs-toggle="modal"
                                                    data-bs-target="#admin-modal"
                                                    class="btn btn-icon btn-sm btn-primary-transparent rounded-pill"
                                                    :title="$t('global.update')">
                                                    <i class="ri-edit-line"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <th class="text-center" colspan="8">{{ $t('global.NoDataFound') }}</th>
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
        <ModalCreateAndUpdate v-model="modalShow" :type="type" :dataRow="dataRow" @created="getData(pagePaginate)" />
        <SendNotification :selectedUser="selectedUser" :type="'App\\Models\\Student'" />
    </div>
</template>

<script>
import { onBeforeMount, inject, ref } from "vue";
import crud from "../../../composable/crud_structure";
import ModalCreateAndUpdate from "./ModalCreateAndUpdate.vue"
import SendNotification from "../../../components/general/SendNotification.vue"
export default {
    name: "index",
    components: {
        ModalCreateAndUpdate, SendNotification
    },
    setup() {
        const emitter = inject('emitter');
        const selectedUser = ref({});

        const { getData, loading, data, dataPaginate, permission, uri, showModelCreate, showEditMode, showModelReason, deleteData, search, type, dataRow, modalShow, reasonShow ,pagePaginate} = crud();

        search.value = {
            searchKey: '',
            searchInTranslations: false,
            columns: ['id', 'name', 'phone','birth_date','guardian_phone','gender'],
            searchInRelations: [
                {
                    relation: 'level',
                    columns: ['name'],
                    searchInRelationTranslations: false
                },
                {
                    relation: 'memorizationType',
                    columns: ['name'],
                    searchInRelationTranslations: false
                },
                {
                    relation: 'nationality',
                    columns: ['name'],
                    searchInRelationTranslations: false
                },
                {
                    relation: 'city',
                    columns: ['name'],
                    searchInRelationTranslations: false
                },
                {
                    relation: 'country',
                    columns: ['name'],
                    searchInRelationTranslations: false
                },
                {
                    relation: 'memorizationAmount',
                    columns: ['name'],
                    searchInRelationTranslations: false
                }

            ]
        }

        onBeforeMount(() => {
            uri.value = 'student';
            getData();
        });


        return { getData, loading, search, permission, deleteData, showEditMode, showModelCreate, showModelReason, data, dataPaginate, type, dataRow, modalShow, reasonShow, selectedUser ,pagePaginate};

    }
}
</script>
