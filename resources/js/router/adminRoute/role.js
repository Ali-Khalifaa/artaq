import Role from "../../views/admin/role/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'role',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'role',
                component: Role,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('role read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
