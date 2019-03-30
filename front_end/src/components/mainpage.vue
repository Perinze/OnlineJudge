<template>
    <div class="mainpage">
        <div class="content-background"></div>
        <div>
            <div class="main-carousel">

            </div>
            <div class="main-statistics">
                <div class="block-title">Statistics</div>
                <div class="main-statistics-content">
                    <div style="width: 8%"></div>
                    <statistics-card
                            title="提交量"
                            num="24,587,987"
                    >
                    </statistics-card>
                    <div style="width: 5%;"></div>
                    <statistics-card
                            title="通过量"
                            num="12,453,566"
                    >
                    </statistics-card>
                    <div style="width: 5%;"></div>
                    <statistics-card
                            title="访问量"
                            num="1,432,567"
                    >
                    </statistics-card>
                    <div style="width: 8%"></div>
                </div>
            </div>
            <div class="main-contest-list">

            </div>
        </div>
    </div>
</template>

<script>
    import statisticsCard from "./main-statistics-card"

    export default {
        name: "mainpage",
        components: {statisticsCard}
    }
</script>

<style scoped>
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

    .main-statistics {
        position: relative;
        top: 30px;
    }

    .main-statistics .block-title {
        position: relative;
        font-size: 2em;
        left: 8%;
        margin-bottom: 7px;
    }

    .main-statistics .main-statistics-content {
        display: flex;
    }

    .main-statistics >div {
        flex: 1 1 auto;
    }
</style>