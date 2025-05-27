import setting from "../../views/admin/setting/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'setting',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'setting',
                component: setting,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('setting read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
