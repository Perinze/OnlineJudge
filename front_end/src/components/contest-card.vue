<template>
    <div class="contest-card" v-on:click="gotoLink('/contest/'+contestId)">
        <div class="contest-card-info">
            <div class="contest-type">{{contestType}}</div>
            <div class="contest-nick">{{contestNick}}</div>
        </div>
        <div class="contest-card-num">{{contestNum}}</div>
    </div>
</template>

<script>
    export default {
        name: "contest-card",
        props: [ 'contestId', 'contestType', 'contestNick', 'contestNum' ],
        methods: {
            gotoLink(link) {
                this.$router.push(link);
            }
        }
    }
</script>

<style scoped>
    .contest-card {
        display: flex;
        align-items: flex-start;
        width: 228px;
        height: 137px;
        background:rgba(80,161,204,1);
        box-shadow:0px 5px 10px rgba(0,0,0,0.3);
        margin: 0 10px 41px 11px;
        border-radius: 10px;
    }

    .contest-card .contest-card-info {
        width:126px;
        height:49px;
        font-size:14px;
        font-weight: bold;
        line-height:17px;
        color:rgba(255,255,255,1);
        opacity:1;
        position: relative;
        left: 16px;
        top: 74px;
    }

    .contest-card .contest-card-info .contest-type {
        font-size: 23px;
        font-weight: 400;
    }

    .contest-card .contest-card-info .contest-nick {
        margin-top: 9px;
    }

    .contest-card .contest-card-num {
        position: sticky;
        margin-top: 6px;
        margin-left: auto;
        margin-right: 12px;
        width:37px;
        height:20px;
        font-size:14px;
        font-weight:600;
        line-height:20px;
        color:rgba(255,255,255,1);
    }
</style>