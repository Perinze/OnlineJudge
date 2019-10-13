<template>
    <div class="discuss-list">
        <div class="list">
            <div class="element-card"
                 v-for="index in 3"
            >

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "discusslist"
    }
</script>

<style scoped>
    .discuss-list {
        position: relative;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        overflow-y: scroll;
        padding-left: 25px;
    }

    .list {

    }

    .list:first-child {
        margin-top: 88px;
    }

    .element-card {
        background: white;
        border-radius: .5em;
        width: 90%;
        height: 150px;
        display: flex;
        align-items: center;
        margin: 0 auto 30px auto;
        overflow: hidden;
        min-width: 875px;
        max-width: 990px;
        cursor: pointer;
    }
</style>