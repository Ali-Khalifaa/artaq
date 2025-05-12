import joinUs from "../../views/admin/joinUs/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'joinUs',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'joinUs',
                component: joinUs,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('join us read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
