<template>
    <div class="mainpage"><!--overflow-y:scroll；-->
        <!--背景图-->
        <div class="content-background"></div>
        <!--页面内容-->
        <div class="mainpage-content" align="center">
            <div class="main-carousel">
                <el-carousel :interval="7500" type="card" height="250px" trigger="click">
                    <el-carousel-item v-for="item in 3" :key="item">
                        <h3>{{ item }}</h3>
                    </el-carousel-item>
                </el-carousel>
            </div>
            <div class="main-statistics" align="left">
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
                    <div class="statistics-card-block" style="width: 51px;flex: 1 1 auto;"></div>
                </div>
            </div>
            <div class="main-contest-list" align="left">
                <div class="block-title">Contest</div>
                <div class="main-contest-list-content">
                    <contest-card
                            v-for="index in 30"
                            v-bind:key="index"
                            contest-nick="大学生程序设计竞赛"
                            contest-type="ACM"
                            contest-num="2,244"
                    >
                    </contest-card>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import contestCard from "../components/contest-card"
    import statisticsCard from "../components/main-statistics-card"

    export default {
        name: "mainpage",
        components: { statisticsCard, contestCard }
    }
</script>

<style>

    /*element-ui carousel START*/

    .el-carousel {
        overflow: unset !important;
    }

    .main-carousel .el-carousel__indicators--outside button{
        background-color: #338bb8 !important;
    }

    .main-carousel .el-carousel__indicators--outside .is-active button{
        background-color: #338bb8 !important;
    }

    .el-carousel__item h3 {
        color: #475669;
        font-size: 14px;
        opacity: 0.75;
        line-height: 200px;
        margin: 0;
    }

    .el-carousel__container .is-active {
        box-shadow: 0 20px 20px rgba(0,0,0,0.1);
    }

    .el-carousel__item:nth-child(2n) {
        background-color: #99a9bf;
        border-radius: 10px;
    }

    .el-carousel__item:nth-child(2n+1) {
        background-color: #d3dce6;
        border-radius: 10px;
    }

    /*element-ui carousel END*/

    .mainpage {
        position: relative;
        overflow-x: hidden;
        overflow-y: scroll;
        display: flex;
        flex-direction: column;
        width: 100%;
        height: 100%;
    }

    .mainpage ::-webkit-scrollbar-track {
        opacity: 0;
        /*background: #880000;*/
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0); border-radius: 10px;
    }

    .content-background {
        z-index: -1;
        position: absolute;
        width: 100%;
        height: 100%;
        filter: blur(30px) brightness(1.15) opacity(0.50);
        /*background: white;*/
        background: url("../assets/background/background-main.png") no-repeat scroll;
        background-size: 100% 422px;
        top: -32px;

    }

    .mainpage-content {
        position: relative;
    }

    .main-carousel {
        position: relative;
        top: 88px;
        width: 1230px;
    }

    .main-statistics {
        position: relative;
        top: 101px;
        margin: 0 auto;
        max-width: 1330px;
    }

    .block-title {
        position: relative;
        font-size: 18px;
        font-weight: 700;
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
        margin: 0 auto;
        max-width: 1330px;
    }

    .main-contest-list .main-contest-list-content {
        margin: 0 0 0 43px;
        position: relative;
        top: 12px;
        display: flex;
        flex-wrap: wrap;
    }

    @media (max-width: 1543px) and (min-width: 1280px) {
        .main-carousel {
            width: 996px;
            margin-left: 27px;
        }

        .el-carousel__item {
            /*height: 191px !important;*/
        }

        .main-contest-list {
            max-width: 1039px;
        }

        .main-contest-list-content {
            margin-left: 33px !important;
        }

        .main-statistics {
            max-width: 1039px;
        }

        .main-statistics .main-statistics-content {
            /*margin-left: 10px;*/
        }

        .statistics-card-block {
            width: 23px !important;
        }
    }
</style>