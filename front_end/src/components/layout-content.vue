<template>
    <div class="layout-content">
        <div class="content-background">
            <component :is="content"></component>
        </div>
        <div></div>
    </div>
</template>

<script>
    export default {
        name: "layout-content",
        props: ['content']
    }
</script>

<style scoped>
    .layout-content {
        background: #8A8A8A;
        position: fixed;
        /*padding-left: 200px;*/
        width: 100%;
        height: 100%;
    }

    .content-background {
        filter: blur(10px);
        background-image: url("../assets/logo.png");
    }
</style>