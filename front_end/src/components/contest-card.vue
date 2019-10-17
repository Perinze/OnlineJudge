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

<style lang="scss" scoped>
    .contest-card {
        display: flex;
        align-items: flex-start;
        width: 228px;
        height: 137px;
        /* TODO 找个背景svg */
        background:rgba(80,161,204,0.3);
        -webkit-box-shadow:0 2px 15px rgba(0,0,0,0.08);
        -moz-box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        margin: 0 10px 41px 11px;
        border-radius: 10px;
        .contest-card-info {
            position: relative;
            width:126px;
            height:49px;
            left: 16px;
            top: 74px;
            font: {
                size: 14px;
                weight: bold;
            }
            line-height: 17px;
            color: rgba(255,255,255,1);
            .contest-type {
                font: {
                    size: 23px;
                    weight: 400;
                }
            }
            .contest-nick {
                margin-top: 9px;
            }
        }
        .contest-card-num {
            position: sticky;
            margin: 6px 12px 0 auto;
            width: 37px;
            height: 20px;
            font: {
                size: 14px;
                weight: 600;
            }
            line-height: 20px;
            color: rgba(255,255,255,1);
        }
    }
</style>