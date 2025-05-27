import circleTypes from "../../views/admin/circleTypes/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'circleTypes',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'circleTypes',
                component: circleTypes,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('circle type read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
