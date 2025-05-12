<template>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">{{ $t('global.roleAndPermissions') }}</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}">{{$t('global.home')}}</router-link></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $t('global.roleAndPermissions') }}</li>
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
                            <button v-if="permission.includes('role create')" @click="showModelCreate" class="btn btn-sm btn-primary-light" data-bs-toggle="modal" data-bs-target="#role-modal">
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
                                    <th scope="col">{{ $t('global.name') }}</th>
                                    <th scope="col">{{ $t('global.status') }}</th>
                                    <th scope="col">{{ $t('global.action') }}</th>
                                </tr>
                                </thead>
                                <tbody v-if="data && data.length">
                                <tr v-for="(item,index) in data" :key="item.id">
                                    <td scope="row">{{index + 1}}</td>

                                    <td>{{item.name}}</td>
                                    <td>
                                        <span class="badge rounded-pill bg-success-transparent" v-if="item.status">{{$t('global.activated')}}</span>
                                        <span class="badge rounded-pill bg-danger-transparent" v-else>{{$t('global.Inactive')}}</span>
                                    </td>
                                    <td>
                                        <div class="hstack gap-2 fs-15">
                                            <button v-if="permission.includes('role edit')"
                                                @click.prevent="showEditMode(item)"
                                                data-bs-toggle="modal" data-bs-target="#role-modal"
                                               class="btn btn-icon btn-sm btn-info-transparent rounded-pill"><i
                                                class="ri-edit-line"></i></button>
                                            <a href="#" @click.prevent="deleteData(item.id,index)" v-if="permission.includes('role delete')"
                                               class="btn btn-icon btn-sm btn-danger-transparent rounded-pill"><i
                                                class="ri-delete-bin-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <th class="text-center" colspan="7">{{ $t('global.NoDataFound') }}</th>
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
        <!-- End:: data table -->
        <ModalCreateAndUpdate v-model="modalShow" :type="type" :dataRow="dataRow" @created="getData(pagePaginate)"/>
    </div>
</template>

<script>
import {onBeforeMount,inject} from "vue";
import crud from "../../../composable/crud_structure";
import ModalCreateAndUpdate from "./ModalCreateAndUpdate.vue"

export default {
    name: "index",
    components:{
        ModalCreateAndUpdate
    },
    setup(){
        const emitter = inject('emitter');

        const {getData,loading,data,dataPaginate,permission,uri,showModelCreate,showEditMode,deleteData,search,type,dataRow,modalShow,pagePaginate} = crud();


        search.value = {
            searchKey : '',
            searchInTranslations: false,
            columns: ['id','name'],
            searchInRelations: [
                {
                    relation: 'permissions',
                    columns: ['name'],
                    searchInRelationTranslations:false
                }
            ]
        }

        onBeforeMount(() => {
            uri.value = 'roles';
            getData();
        });


        return {getData,loading,search,permission,deleteData,showEditMode,showModelCreate,data,dataPaginate,type,dataRow,modalShow,pagePaginate};

    }
}
</script>

