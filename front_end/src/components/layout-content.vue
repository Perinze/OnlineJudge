<template>
    <div>
        <div class="content-background"></div>
        <div></div>
    </div>
</template>

<script>
    export default {
        name: "layout-content"
    }
</script>

<style scoped>
    .content-background {
        filter: blur(10px);
        background-image: url("../assets/logo.png");
    }
</style>