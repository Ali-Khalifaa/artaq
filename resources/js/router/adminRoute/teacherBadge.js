import teacherBadge from "../../views/admin/teacherBadge/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'teacherBadge',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'teacherBadge',
                component: teacherBadge,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('teacher badge read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
