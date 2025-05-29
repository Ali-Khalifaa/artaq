import quran from "../../views/admin/quran/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'quran',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'quran',
                component: quran,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('quran read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
