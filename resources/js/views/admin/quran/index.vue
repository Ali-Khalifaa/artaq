<template>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">{{ $t('global.quran') }}</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}">{{$t('global.home')}}</router-link></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $t('global.quran') }}</li>
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
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mb-2">
                            <table class="table text-nowrap table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">{{ $t('global.surah_number') }}</th>
                                    <th scope="col">{{ $t('global.surah_name') }}</th>
                                    <th scope="col">{{ $t('global.verse_count') }}</th>
                                    <th scope="col">{{ $t('global.revelation_type') }}</th>
                                    <th scope="col">{{ $t('global.action') }}</th>
                                </tr>
                                </thead>
                                <tbody v-if="data && data.length">
                                <tr v-for="(item,index) in data" :key="item.id">
                                    <td>{{item.number}}</td>
                                    <td>{{item.name}}</td>
                                    <td>{{item.verse_count}}</td>
                                    <td>{{$t('global.'+item.revelation_type)}}</td>
                                    <td>
                                        <div class="hstack gap-2 fs-15">
                                            <button @click.prevent="showDataModel(item)"
                                                data-bs-toggle="modal" data-bs-target="#show"
                                                style="margin: 0 3px"
                                                class="btn btn-icon btn-sm btn-success-transparent rounded-pill"
                                                :title="$t('global.show')">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <th class="text-center" colspan="5">{{ $t('global.NoDataFound') }}</th>
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
        <Show v-model="showData" :dataRow="dataRow"/>
    </div>
</template>

<script>
import {onBeforeMount,inject,watch,ref,computed} from "vue";
import crud from "../../../composable/crud_structure";
import Show from "./show.vue";

export default {
    name: "index",
    components:{
        Show
    },
    setup(){
        const emitter = inject('emitter');

        const {getData,loading,data,dataPaginate,permission,uri,showModelCreate,showDataModel,showEditMode,showModelReason,deleteData,search,type,dataRow,modalShow,reasonShow,pagePaginate} = crud();

        search.value = {
            searchKey : '',
            searchInTranslations: false,
            columns: ['id','name','normalized_name','number','revelation_type'],
            searchInRelations: [
                // {
                //     relation: 'country',
                //     columns: ['name'],
                //     searchInRelationTranslations:false
                // }
            ]
        }

        onBeforeMount(() => {
            uri.value = 'quran';
            getData();
        });


        return {getData,loading,search,permission,deleteData,showEditMode,showModelCreate,showDataModel,showModelReason,data,dataPaginate,type,dataRow,modalShow,reasonShow,pagePaginate};

    }
}
</script>

