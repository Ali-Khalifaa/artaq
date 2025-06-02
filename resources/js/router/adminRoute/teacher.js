import teacher from "../../views/admin/teacher/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'teacher',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'teacher',
                component: teacher,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('teacher read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
