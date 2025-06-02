import levelTask from "../../views/admin/levelTask/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'levelTask',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'levelTask',
                component: levelTask,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('level task read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
