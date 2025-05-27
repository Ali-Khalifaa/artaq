import city from "../../views/admin/city/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'city',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'city',
                component: city,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('city read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
