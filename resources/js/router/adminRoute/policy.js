import policy from "../../views/admin/policy/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'policy',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'policy',
                component: policy,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('policy read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
