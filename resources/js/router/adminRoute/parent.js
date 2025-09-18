import parent from "../../views/admin/parent/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'parent',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'parent',
                component: parent,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('parent read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
