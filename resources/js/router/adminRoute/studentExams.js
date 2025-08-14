import studentExams from "../../views/admin/studentExams/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'studentExams',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'studentExams',
                component: studentExams,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('exam read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
