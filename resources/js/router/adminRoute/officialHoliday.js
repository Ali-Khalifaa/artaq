import officialHoliday from "../../views/admin/officialHoliday/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'officialHoliday',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'officialHoliday',
                component: officialHoliday,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('official holiday read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
