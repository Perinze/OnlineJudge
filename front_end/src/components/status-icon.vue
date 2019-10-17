<template>
    <div class="status-icon">
        <div class="icon">
            <img src="../../assets/icon/yes.svg" v-if="isSuccess">
            <img src="../../assets/icon/no.svg" v-else>
        </div>
        <span class="times" :class="[isSuccess?'ac-color':'wa-color']">{{times}}</span>
    </div>
</template>

<script>
    export default {
        name: "status-icon",
        props: [ 'isSuccess','times' ],
    }
</script>

<style lang="scss" scoped>
    .status-icon {
        display: flex;
        align-items: center;
        margin-left: 2px;
    }

    .icon {
        position: absolute;
        > img {
            width: 20px;
            height: 20px;
        }
    }

    .times {
        position: relative;
        font-size: 12px;
        font-weight: bold;
        top: 9px;
        left: 0;
        bottom: 0;
        margin-left: auto;
        margin-right: 0;
        /*padding: 10px 0 0 15px;*/
    }
</style>