import level from "../../views/admin/level/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'level',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'level',
                component: level,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('level read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
