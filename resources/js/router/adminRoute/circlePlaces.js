import circlePlaces from "../../views/admin/circlePlaces/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'circlePlaces',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'circlePlaces',
                component: circlePlaces,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('circle place read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
