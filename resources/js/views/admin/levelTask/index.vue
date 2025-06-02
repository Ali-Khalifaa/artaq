<template>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">{{ $t('global.levelTask') }}</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}">{{$t('global.home')}}</router-link></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $t('global.levelTask') }}</li>
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
                            <button v-if="permission.includes('level task create')" @click="showModelCreate" class="btn btn-sm btn-primary-light" data-bs-toggle="modal" data-bs-target="#category-service">
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
                                    <th scope="col">{{ $t('global.level') }}</th>
                                    <th scope="col">{{ $t('global.fromSurah') }}</th>
                                    <th scope="col">{{ $t('global.toSurah') }}</th>
                                    <th scope="col">{{ $t('global.fromAyah') }}</th>
                                    <th scope="col">{{ $t('global.toAyah') }}</th>
                                    <th scope="col">{{ $t('global.action') }}</th>
                                </tr>
                                </thead>
                                <tbody v-if="data && data.length">
                                <tr v-for="(item,index) in data" :key="item.id">
                                    <td scope="row">{{index + 1}}</td>
                                    <td>{{item.level?.name}}</td>
                                    <td>{{item.from_surah?.name}}</td>
                                    <td>{{item.to_surah?.name}}</td>
                                    <td>{{truncateString(item.from_ayah?.text,100)}}
                                        <span class="ayaNumber" style="font-size: 0.91em;">‎﴿{{makeNumberArabic(item.from_ayah?.number_in_surah)}}﴾‏</span>
                                    </td>
                                    <td>{{truncateString(item.to_ayah?.text,100)}}
                                        <span class="ayaNumber" style="font-size: 0.91em;">‎﴿{{makeNumberArabic(item.to_ayah?.number_in_surah)}}﴾‏</span>
                                    </td>
                                    <td>
                                        <div class="hstack gap-2 fs-15">
                                            <button v-if="permission.includes('level task edit')"
                                                @click.prevent="showEditMode(item)"
                                                data-bs-toggle="modal" data-bs-target="#category-service"
                                                    class="btn btn-icon btn-sm btn-primary-transparent rounded-pill"
                                                    :title="$t('global.update')">
                                                <i class="ri-edit-line"></i>
                                            </button>

                                             <a href="#" @click.prevent="deleteData(item.id,index)" v-if="permission.includes('level task delete')"
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

        const {getData,loading,data,dataPaginate,permission,uri,showModelCreate,showEditMode,truncateString,showModelReason,deleteData,search,type,dataRow,modalShow,reasonShow,pagePaginate} = crud();

        search.value = {
            searchKey : '',
            searchInTranslations: false,
            columns: ['id'],
            searchInRelations: [
                {
                    relation: 'level',
                    columns: ['name'],
                    searchInRelationTranslations:false
                },
                {
                    relation: 'fromSurah',
                    columns: ['name','normalized_name'],
                    searchInRelationTranslations:false
                },
                {
                    relation: 'toSurah',
                    columns: ['name','normalized_name'],
                    searchInRelationTranslations:false
                },
                {
                    relation: 'fromAyah',
                    columns: ['text','text_normalized','number_in_surah'],
                    searchInRelationTranslations:false
                },
                {
                    relation: 'toAyah',
                    columns: ['text','text_normalized','number_in_surah'],
                    searchInRelationTranslations:false
                }
            ]
        }

        onBeforeMount(() => {
            uri.value = 'level-tasks';
            getData();
        });

        let makeNumberArabic = (num) => {
            if (typeof num !== 'number') {
                return num; // Return as is if not a number
            }
            return num.toString().replace(/\d/g, d => '٠١٢٣٤٥٦٧٨٩'[d]);
        }


        return {getData,loading,search,permission,deleteData,makeNumberArabic,showEditMode,showModelCreate,truncateString,showModelReason,data,dataPaginate,type,dataRow,modalShow,reasonShow,pagePaginate};

    }
}
</script>

<style scoped>
.ayaNumber {
    font-family: hafs;
}

.ayaNumber {
    font-size: 0.9em;
    white-space: nowrap;
    color: #050;
    cursor: pointer;
}
</style>

