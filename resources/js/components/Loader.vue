<template>
    <div class="shadow opacity-50"></div>
    <div class="main">
        <img src="/assets/images/media/loader.svg" alt="">
    </div>
</template>

<script>
export default {
    name: "loader"
}
</script>

<style scoped>
.shadow{
    position: fixed;
    width: 100%;
    height: 100%;
    background-color: #FFFFFF;
    opacity: 1;
    z-index: 15000;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.main{
    position: fixed;
    width: 100%;
    height: 100%;
    max-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 15000;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

</style>
