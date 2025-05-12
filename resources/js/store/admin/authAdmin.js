import Cookies from "js-cookie";
import adminApi from '../../api/adminAxios';
import router from "../../router/adminRoute";

// state
const state = {
    permission: [],
    user: null,
    type: '',
    service: JSON.parse(localStorage.getItem("service")) || ''
}

// getters
const getters = {
    permission: state => state.permission,
    user: state => state.user
}

// mutations
const mutations = {
    editPermission(state,permission){
        state.permission = permission;
    },
    editUser(state,user){
        state.user = user;
        if(!state.service){
            if(user.services){
                state.service = user?.services[0] || '';
                localStorage.setItem("service",JSON.stringify(user?.services[0] || ''));
            }
        }
    },
    editService(state,service){
        state.service = service || '';
        localStorage.setItem("service",JSON.stringify(service || ''))
    },
    editType(state,type){
        state.type = type || 'admin';
    },
    logoutToken(state){
        state.roles = null;
        state.user = null;
        state.permission = [];
        state.type = '';
        state.service = '';
        Cookies.remove('token');
        localStorage.removeItem("service");
    },
};

// actions
const actions = {

}

export default  {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
