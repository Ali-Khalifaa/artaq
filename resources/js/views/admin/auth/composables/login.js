import adminApi from "../../../../api/adminAxios";
import { ref } from "vue";
import { useStore } from 'vuex'
import Cookies from "js-cookie";
import {useRouter} from "vue-router";

export default function login() {
    const errors = ref({}); //errors for create or update
    const loading = ref(false);
    const store = useStore();
    const router = useRouter();

    //store fine  request
    const adminLogin = async (data) => {
        loading.value=true
        errors.value={}
        await adminApi.post('dashboard/auth/login',data).then((result)=>{
            let l =result.data.data;
            Cookies.set("token",l.access_token);

            store.commit('authAdmin/editPermission',l.permission || []);
            store.commit('authAdmin/editUser',l.user);
            store.commit('authAdmin/editType',l.type || 'admin');


            return router.push({name:`dashboard`});

        }).catch((e) => {
            errors.value = e.response.data;
            loading.value=false
        })
        loading.value=false
    }

    return {
        errors,
        loading,
        adminLogin,
    };
}

