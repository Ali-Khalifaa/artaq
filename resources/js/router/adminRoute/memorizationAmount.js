import memorizationAmount from "../../views/admin/memorizationAmount/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'memorizationAmount',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'memorizationAmount',
                component: memorizationAmount,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('memorization amount read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
