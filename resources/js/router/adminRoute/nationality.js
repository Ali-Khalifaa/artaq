import nationality from "../../views/admin/nationality/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'nationality',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'nationality',
                component: nationality,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('nationality read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
