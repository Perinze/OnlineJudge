<template>
    <div class="page404">
        <span class="title-404">404</span>
        <span class="detail-en">Can't found the page</span>
        <span class="detail">网页丢失</span>
    </div>
</template>

<script>
    export default {
        name: "page404"
    }
</script>

<style scoped>
    .page404 {
        width: 100%;
        height: 100%;
        padding-left: 24px;
        padding-bottom: 130px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .title-404 {
        display: block;
        font-size: 155px;
        font-weight: bold;
        /*font-family: countdown;*/
        line-height: 140px;
    }

    .detail-en {
        display: block;
        font-size: 28px;
        font-weight: bold;
    }

    .detail {
        display: block;
        font-size: 20px;
        /*font-weight: bold;*/
    }
</style>