<template>
<router-view></router-view>
</template>

<script>
import adminApi from "./api/adminAxios";
import {onMounted, ref} from "vue";

export default {
    name: "app",
    setup(){
        let getLanguage = () => {
            adminApi.get(`dashboard/get-language`)
                .then((res) => {
                    let l = res.data.data;
                    localStorage.setItem('languages',JSON.stringify(l))
                })
                .catch((err) => {
                    console.log(err.response.data);
                })

        }

        onMounted(()=>{

            // getLanguage
            getLanguage();

        })
    }
}
</script>

<style scoped>

</style>
