<template>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">{{ $t('global.databaseBackup') }}</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}">{{$t('global.home')}}</router-link></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $t('global.databaseBackup') }}</li>
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
                            <button v-if="permission.includes('database backup create')" @click="startBackup" class="btn btn-sm btn-primary-light" data-bs-toggle="modal" data-bs-target="#types-of-rating">
                                <i class="ri-add-line me-1 fw-semibold align-middle"></i>{{ $t('global.add') }}
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mb-2">
                            <table class="table text-nowrap table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ $t('global.file_name') }}</th>
                                    <th scope="col">{{ $t('global.created_at') }}</th>
                                </tr>
                                </thead>
                                <tbody v-if="data && data.length">
                                <tr v-for="(item,index) in data" :key="item.id">
                                    <td scope="row">{{index + 1}}</td>
                                    <td>{{item.path}}</td>
                                    <td>{{item.created_at}}</td>
                                    <td>
                                        <div class="hstack gap-2 fs-15">
                                            <a href="#" :download="item.full_path" class="btn btn-icon btn-sm btn-success-transparent rounded-pill"
                                            :title="$t('global.downloadFile')">
                                                <i class="ri-download-line"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <th class="text-center" colspan="3">{{ $t('global.NoDataFound') }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :limit="2" :data="dataPaginate" @pagination-change-page="getData">
                            <template #prev-nav>
                                <span>&lt; {{$t('global.Previous')}}</span>
                            </template>
                            <template #next-nav>
                                <span>{{$t('global.Next')}} &gt;</span>
                            </template>
                        </Pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {onBeforeMount,inject,watch,ref,computed} from "vue";
import crud from "../../../composable/crud_structure";
import adminApi from "../../../api/adminAxios";
import {useI18n} from "vue-i18n";

export default {
    name: "index",

    setup(){
        const emitter = inject('emitter');
        const {t} = useI18n({});

        const {getData,loading,data,dataPaginate,permission,uri,showModelCreate,showEditMode,deleteData,search,type,dataRow,modalShow} = crud();

        search.value = {
            searchKey : '',
            searchInTranslations: false,
            columns: ['id','path'],
            searchInRelations: [
                // {
                //     relation: 'relation_name',
                //     columns: ['name'],
                //     searchInRelationTranslations:false
                // }
            ]
        }

        onBeforeMount(() => {
            uri.value = 'backup';
            getData();
        });


        return {getData,loading,search,permission,deleteData,showEditMode,showModelCreate,data,dataPaginate,type,dataRow,modalShow,t};

    },
    methods: {
    async startBackup() {
        this.loading = true;
        adminApi.post(`dashboard/backup`)
            .then((res) => {
                Swal.fire({
                    icon: 'success',
                    title: `${this.t('global.AddedSuccessfully')}`,
                    showConfirmButton: false,
                    timer: 1500
                });
                this.getData();
            })
            .catch((err) => {
                console.error('Error starting backup:', err);
            })
            .finally(() => {
                this.loading = false;
            });
    },

  },
}
</script>

