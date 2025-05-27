import digitalBadge from "../../views/admin/digitalBadge/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'digitalBadge',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'digitalBadge',
                component: digitalBadge,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('digital badge read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
