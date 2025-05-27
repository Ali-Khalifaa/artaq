import memorizationType from "../../views/admin/memorizationType/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'memorizationType',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'memorizationType',
                component: memorizationType,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('memorization type read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
