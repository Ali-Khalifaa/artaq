<template>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">{{ $t('global.employees') }}</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><router-link :to="{ name: 'dashboard' }">{{ $t('global.home')
                                }}</router-link></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $t('global.employees') }}</li>
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
                            <button v-if="permission.includes('admin create')" @click="showModelCreate"
                                class="btn btn-sm btn-primary-light" data-bs-toggle="modal"
                                data-bs-target="#admin-modal">
                                <i class="ri-add-line me-1 fw-semibold align-middle"></i>{{ $t('global.add') }}
                            </button>

                            <button @click="selectedUser = 'all'" data-bs-toggle="modal"
                                v-if="permission.includes('admin send notification')"
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
                                        <th scope="col">{{ $t('global.email') }}</th>
                                        <th scope="col">{{ $t('global.role_name') }}</th>
                                        <th scope="col">{{ $t('global.nationality') }}</th>
                                        <th scope="col">{{ $t('global.country') }}</th>
                                        <th scope="col">{{ $t('global.Activate the account') }}</th>
                                        <th scope="col">{{ $t('global.created_at') }}</th>
                                        <th scope="col">{{ $t('global.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody v-if="data && data.length">
                                    <tr v-for="(item, index) in data" :key="item.id">
                                        <td scope="row">{{ item.code }}</td>
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
                                        <td>{{ item.email }}</td>
                                        <td>{{ item.role_name }}</td>
                                        <td>{{ item.nationality?.name }}</td>
                                        <td>{{ item.country?.name }}</td>
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
                                                    v-if="permission.includes('admin send notification')"
                                                    data-bs-target="#send-notification"
                                                    :title="$t('global.send_notification')"
                                                    class="btn btn-icon btn-sm btn-warning-transparent rounded-pill"><i
                                                        class="bx bx-bell header-link-icon"></i></a>

                                                <button v-if="permission.includes('admin edit')"
                                                    @click.prevent="showEditMode(item)" data-bs-toggle="modal"
                                                    data-bs-target="#admin-modal"
                                                    class="btn btn-icon btn-sm btn-primary-transparent rounded-pill"
                                                    :title="$t('global.update')">
                                                    <i class="ri-edit-line"></i>
                                                </button>
                                                <button @click.prevent="showDataModel(item)"
                                                        data-bs-toggle="modal" data-bs-target="#show"
                                                        class="btn btn-icon btn-sm btn-success-transparent rounded-pill"
                                                        :title="$t('global.show')">
                                                    <i class="ri-eye-line"></i>
                                                </button>
                                                <!-- <button v-if="permission.includes('admin edit')"
                                                    @click.prevent="showModelReason(item, (item.status ? 'Deactivation' : 'Activation'))"
                                                    data-bs-toggle="modal" data-bs-target="#reason"
                                                    :class="[item.status ? 'btn-warning-transparent' : 'btn-success-transparent', 'btn btn-icon btn-sm rounded-pill']"
                                                    :title="item.status ? $t('global.deactivate') : $t('global.activation')">
                                                    <i
                                                        :class="item.status ? 'bi bi-exclamation-circle' : 'bi bi-check-circle-fill'"></i>
                                                </button>
                                                <button @click.prevent="showModelReason(item, 'Delete')"
                                                    v-if="permission.includes('admin delete')" data-bs-toggle="modal"
                                                    data-bs-target="#reason"
                                                    class="btn btn-icon btn-sm btn-danger-transparent rounded-pill"
                                                    :title="$t('global.delete')">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button> -->
                                            </div>
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
        <SendNotification :selectedUser="selectedUser" :type="'App\\Models\\Admin'" />
        <reason v-model="reasonShow" :type="type" :dataRow="dataRow" :model="'App\\Models\\Admin'" :url="'admins'"
            @created="getData(pagePaginate)" />
        <Show v-model="showData" :dataRow="dataRow" type="order" @created="getData(pagePaginate)" />
    </div>
</template>

<script>
import { onBeforeMount, inject, ref } from "vue";
import crud from "../../../composable/crud_structure";
import ModalCreateAndUpdate from "./ModalCreateAndUpdate.vue"
import SendNotification from "../../../components/general/SendNotification.vue"
import Show from "./Show.vue";
export default {
    name: "index",
    components: {
        ModalCreateAndUpdate, SendNotification,Show
    },
    setup() {
        const emitter = inject('emitter');
        const selectedUser = ref({});

        const { getData, loading, data, dataPaginate, permission, uri, showModelCreate,showDataModel,showData, showEditMode, showModelReason, deleteData, search, type, dataRow, modalShow, reasonShow ,pagePaginate} = crud();

        search.value = {
            searchKey: '',
            searchInTranslations: false,
            columns: ['id', 'name', 'phone', 'email','code'],
            searchInRelations: [
                {
                    relation: 'roles',
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
            ]
        }

        onBeforeMount(() => {
            uri.value = 'admins';
            getData();
        });


        return { getData, loading, search, permission, deleteData, showEditMode,showDataModel,showData, showModelCreate, showModelReason, data, dataPaginate, type, dataRow, modalShow, reasonShow, selectedUser ,pagePaginate};

    }
}
</script>
