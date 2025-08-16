import studentWithoutCircles from "../../views/admin/studentWithoutCircles/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'studentWithoutCircles',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'studentWithoutCircles',
                component: studentWithoutCircles,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('student without circle read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
