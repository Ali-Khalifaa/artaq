import privacy from "../../views/admin/privacy/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'privacy',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'privacy',
                component: privacy,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('privacy read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
