import circles from "../../views/admin/circles/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'circles',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'circles',
                component: circles,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('circle read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
