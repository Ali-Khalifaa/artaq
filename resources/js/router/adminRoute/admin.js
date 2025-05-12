import Admin from "../../views/admin/admin/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'admin',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'admin',
                component: Admin,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('admin read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
