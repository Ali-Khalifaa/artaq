<template>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">{{ $t('global.circleTypes') }}</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}">{{$t('global.home')}}</router-link></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $t('global.circleTypes') }}</li>
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
                            <button v-if="permission.includes('circle type create')" @click="showModelCreate" class="btn btn-sm btn-primary-light" data-bs-toggle="modal" data-bs-target="#category-service">
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
                                    <th scope="col">{{ $t('label.title') }}</th>
                                    <th scope="col">{{ $t('global.created_at') }}</th>
                                    <th scope="col">{{ $t('global.action') }}</th>
                                </tr>
                                </thead>
                                <tbody v-if="data && data.length">
                                <tr v-for="(item,index) in data" :key="item.id">
                                    <td scope="row">{{index + 1}}</td>
                                    <td>{{item.name}}</td>
                                    <td>{{item.created_at}}</td>
                                    <td>
                                        <div class="hstack gap-2 fs-15">
                                            <button v-if="permission.includes('circle type edit')"
                                                @click.prevent="showEditMode(item)"
                                                data-bs-toggle="modal" data-bs-target="#category-service"
                                                    class="btn btn-icon btn-sm btn-primary-transparent rounded-pill"
                                                    :title="$t('global.update')">
                                                <i class="ri-edit-line"></i>
                                            </button>

                                             <a href="#" @click.prevent="deleteData(item.id,index)" v-if="permission.includes('circle type delete')"
                                               class="btn btn-icon btn-sm btn-danger-transparent rounded-pill"><i
                                                class="ri-delete-bin-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <th class="text-center" colspan="4">{{ $t('global.NoDataFound') }}</th>
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
import {onBeforeMount,inject,watch,ref,computed} from "vue";
import ModalCreateAndUpdate from "./ModalCreateAndUpdate.vue"
import crud from "../../../composable/crud_structure";

export default {
    name: "index",
    components:{
        ModalCreateAndUpdate
    },
    setup(){
        const emitter = inject('emitter');

        const {getData,loading,data,dataPaginate,permission,uri,showModelCreate,showEditMode,showModelReason,deleteData,search,type,dataRow,modalShow,reasonShow,pagePaginate} = crud();

        search.value = {
            searchKey : '',
            searchInTranslations: false,
            columns: ['id','name'],
            searchInRelations: [
                // {
                //     relation: 'country',
                //     columns: ['name'],
                //     searchInRelationTranslations:false
                // }
            ]
        }

        onBeforeMount(() => {
            uri.value = 'circle-types';
            getData();
        });


        return {getData,loading,search,permission,deleteData,showEditMode,showModelCreate,showModelReason,data,dataPaginate,type,dataRow,modalShow,reasonShow,pagePaginate};

    }
}
</script>

