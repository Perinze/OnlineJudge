<template>
    <div class="mainpage">
        <div class="content-background"></div>
        <div class="mainpage-content" align="center">
            <div class="main-carousel">
                <el-carousel :interval="4000" type="card" height="250px">
                    <el-carousel-item v-for="item in 6" :key="item">
                        <h3>{{ item }}</h3>
                    </el-carousel-item>
                </el-carousel>
            </div>
            <div class="main-statistics" align="left">
                <!--TODO 适配宽屏幕-->
                <span class="block-title">Statistics</span>
                <div class="main-statistics-content">
                    <div style="width: 55px;flex: 1 1 auto;"></div>
                    <statistics-card
                            title="提交量"
                            num="24,587,987"
                    >
                    </statistics-card>
                    <div style="width: 59px;"></div>
                    <statistics-card
                            title="通过量"
                            num="12,453,566"
                    >
                    </statistics-card>
                    <div style="width: 59px;"></div>
                    <statistics-card
                            title="访问量"
                            num="1,432,567"
                    >
                    </statistics-card>
                    <div style="width: 51px;flex: 1 1 auto;"></div>
                </div>
            </div>
            <div class="main-contest-list" align="left">
                <div class="block-title">Contest</div>
                <div class="main-contest-list-content">
                    <contest-card
                            v-for="index in 8"
                            v-bind:key="index"
                    >
                    </contest-card>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import contestCard from "./contest-card"
    import statisticsCard from "./main-statistics-card"

    export default {
        name: "mainpage",
        components: { statisticsCard, contestCard }
    }
</script>

<style scoped>

    /*element-ui carousel START*/

    .el-carousel__item h3 {
        color: #475669;
        font-size: 14px;
        opacity: 0.75;
        line-height: 200px;
        margin: 0;
    }

    .el-carousel__item:nth-child(2n) {
        background-color: #99a9bf;
    }

    .el-carousel__item:nth-child(2n+1) {
        background-color: #d3dce6;
    }

    /*element-ui carousel END*/

    .mainpage {
        width: 100%;
        height: 100%;
    }

    .content-background {
        z-index: -1;
        position: fixed;
        width: 100%;
        height: 100%;
        filter: blur(10px);
        background: white;
        /*background-image: url("../assets/logo.png");*/
    }

    .mainpage-content {
    }

    .main-carousel {
        position: relative;
        top: 88px;
        width: 1230px;
    }

    .main-statistics {
        position: relative;
        top: 101px;
    }

    .block-title {
        position: relative;
        font-size: 18px;
        font-weight: normal;
        left: 4%;
    }

    .main-statistics .main-statistics-content {
        position: relative;
        top: 14px;
        display: flex;
    }

    .main-contest-list {
        position: relative;
        top: 136px;
    }

    .main-contest-list .main-contest-list-content {
        position: relative;
        top: 12px;
        display: flex;
    }
</style>