<template>
    <div class="modal fade" id="show" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xll modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="adminModalLabel">
                        {{ $t('global.children') }}
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <loader v-if="loading" />
                        <div class="table-responsive mb-2">
                            <table class="table text-nowrap table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ $t('global.Three-part name') }}</th>
                                        <th scope="col">{{ $t('global.email') }}</th>
                                        <th scope="col">{{ $t('global.nationality') }}</th>
                                        <th scope="col">{{ $t('global.country') }}</th>
                                        <th scope="col">{{ $t('global.level') }}</th>
                                        <th scope="col">{{ $t('global.Activate the account') }}</th>
                                        <th scope="col">{{ $t('global.created_at') }}</th>
                                    </tr>
                                </thead>
                                <tbody v-if="user?.students && user?.students.length">
                                    <tr v-for="(item,index) in user?.students" :key="item.id">
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
                                                        <span class="text-muted d-block">{{item.phone}} {{item.country ? '('+item.country?.phone_code + ')' : ''}}</span>
                                                        <span class="text-muted">{{item.gender ? $t('global.'+item.gender) : ''}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ item.email }}</td>
                                        <td>{{ item.nationality?.name }}</td>
                                        <td>{{ item.country?.name }}</td>
                                        <td>{{ item.level?.name }}</td>
                                        <td>
                                            <span class="badge rounded-pill bg-success-transparent"
                                                v-if="item.status">{{ $t('global.activated') }}</span>
                                            <span class="badge rounded-pill bg-danger-transparent" v-else>{{
                                                $t('global.Inactive') }}</span>
                                        </td>
                                        <td>
                                            {{ item.created_at ? new Date(item.created_at).toISOString().slice(0, 10) + ' (' + new Date(item.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) + ')' : '' }}
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

        function defaultData() {
            user.value = '';
            id.value = null;
        }

        function resetModal() {
            defaultData();
            setTimeout(async () => {
                id.value = props.dataRow.id;
                adminApi.get(`dashboard/parent/${props.dataRow.id}`)
                .then((res) => {
                    let l = res.data.data;
                    user.value = l;
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

        return {t, id, loading,user,truncateString};
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
