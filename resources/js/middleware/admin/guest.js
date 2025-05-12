import Cookies from "js-cookie";

let path = '';

export default function guest({  next,store}){
    if (Cookies.get("token")) {

        return next({name: `dashboard${path}`});

    } else {
        return next();
    }
}

