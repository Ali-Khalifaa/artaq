import track from "../../views/admin/track/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'track',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'track',
                component: track,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('track read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
