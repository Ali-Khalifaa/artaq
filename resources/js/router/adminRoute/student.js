import student from "../../views/admin/student/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'student',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'student',
                component: student,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('student read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
