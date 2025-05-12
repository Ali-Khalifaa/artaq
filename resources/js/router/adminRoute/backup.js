import backup from "../../views/admin/backup/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'backup',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'backup',
                component: backup,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('database backup read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
