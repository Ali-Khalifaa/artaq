import Cookies from "js-cookie";
import adminApi from "../../api/adminAxios";
import store from "../../store/admin";

export default function auth({ next, store }){
    if (!Cookies.get("token")) {
        return next({name: 'login'});
    } else {
        adminApi.post(`dashboard/auth/checkToken`)
            .then((res) => {
                let l =res.data.data;
                let name = [];
                l.permission.forEach(el => {
                    name.push(el.name);
                });

                store.commit('authAdmin/editPermission',name);
                store.commit('authAdmin/editUser',l.user);
                store.commit('authAdmin/editType',l.type || 'admin');

                return next();

            })
            .catch((err) => {
                store.commit('authAdmin/logoutToken');
                return next({name: 'login'});
            })
    }
}
