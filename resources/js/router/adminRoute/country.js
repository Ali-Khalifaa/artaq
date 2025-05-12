import country from "../../views/admin/country/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'country',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'country',
                component: country,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('country read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
