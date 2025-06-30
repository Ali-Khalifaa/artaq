import serial from "../../views/admin/serial/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'serial',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'serial',
                component: serial,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('serial read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
