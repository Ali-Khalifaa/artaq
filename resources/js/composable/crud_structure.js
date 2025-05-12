import adminApi from "../api/adminAxios";
import { ref , watch,computed} from "vue";
import { useStore } from 'vuex'
import {useRouter} from "vue-router";
import {useI18n} from "vue-i18n";


export default function crud() {
    const errors = ref({}); //errors for create or update
    const loading = ref(false);
    const store = useStore();
    const router = useRouter();


    let type = ref('create');
    let dataRow = ref('');
    let actionUrl = ref('');
    let actionData = ref('');
    let modalShow = ref(false);
    let reasonShow = ref(false);
    let printShow = ref(false);
    let showData = ref(false);
    let data = ref([]);
    let dataPaginate = ref({});
    let filter = ref('');

    const uri = ref('');
    const pagePaginate = ref(1);
    const {t} = useI18n({});
    let permission = computed(() => store.getters['authAdmin/permission']);


    let getData = (page =  1) => {
        pagePaginate.value = page;
        loading.value = true;
        adminApi.get(`dashboard/${uri.value}?page=${pagePaginate.value}${filter.value}&search=${JSON.stringify(search.value)}`,{
            params: {
                filterColumns:filterColumns.value
            },
        })
            .then((res) => {
                let l = res.data;
                dataPaginate.value = l.pagination;
                data.value = l.data;
            })
            .catch((err) => {
            })
            .finally(() => {
                loading.value = false;
            });
    }


    function deleteData(id,index){
        Swal.fire({
            title: `${t('global.AreYouSureDelete')}`,
            text: `${t("global.YouWontBeAbleToRevertThis")}`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: t('global.yes'),
            cancelButtonText: t('global.no'),
        }).then((result) => {
            if (result.isConfirmed) {
                adminApi.delete(`dashboard/${uri.value}/${id}`)
                    .then((res) => {
                        data.value.splice(index,1);
                        Swal.fire({
                            icon: 'success',
                            title: `${t('global.DeletedSuccessfully')}`,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        getData();
                    })
                    .catch((err) => {
                        Swal.fire({
                            icon: 'error',
                            title: `${t('global.ThereIsAnErrorInTheSystem')}`,
                            text: `${t('global.YouCanNotDelete')}`,
                        });
                    });
            }
        });
    }


    let showModelPrint = (row) => {
        dataRow.value=row;
        printShow.value=true;
    }
    let showDataModel = (row) => {
        dataRow.value=row;
        showData.value=true;
    }

    let showEditMode = (row) => {
        dataRow.value=row;
        type.value='edit';
        modalShow.value=true;
    }
   let showModelCreate = () => {
       dataRow.value=null;
       type.value='create';
       modalShow.value=true;
   }

    let showCopyModel = (row) => {
        dataRow.value=row;
        type.value= 'copy';
        showData.value=true;
    }

   let showModelReason = (row,reasonType,url='',dataAction='') => {
        actionData.value=dataAction;
        actionUrl.value=url;
       dataRow.value=row;
       type.value=reasonType;
       reasonShow.value=true;
   }
   let truncateString = (str, maxLength) => {
       if (str.length > maxLength) {
           return str.slice(0, maxLength) + '...';
       }
       return str;
   }


   //start search
   const search = ref({
        searchKey: '',
        searchInTranslations: false,
        columns: [],
    });

    const filterColumns = ref([]);

    const debounce = ref({})

    watch([search,filterColumns], ([search,filter], [prevSearch,prevFilter]) => {
        clearTimeout(debounce.value);
        debounce.value = setTimeout(() => {
            getData();
        }, 400);
     }, { deep: true });






    return {
        errors,
        loading,
        permission,
        type,
        modalShow,
        reasonShow,
        data,
        dataPaginate,
        search,
        filterColumns,
        dataRow,
        uri,
        t,
        filter,
        getData,
        showEditMode,
        showModelCreate,
        deleteData,
        showModelReason,
        truncateString,
        showModelPrint,
        printShow,
        showCopyModel,
        showDataModel,
        showData,
        actionData,
        pagePaginate,
        actionUrl
    };
}

