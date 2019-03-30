<template>
    <div class="statistics-card">
        <div class="statistics-card-info">
            <span class="card-info-title">{{ title }}</span>
            <span class="card-info-num">{{ num }}</span>
            <span>
                <img class="statistics-icon">
                <span class="statistics-percent"></span>
            </span>
        </div>
        <div class="statistics-card-graph">

        </div>
    </div>
</template>

<script>
    export default {
        name: "main-statistics-card",
        props: [ 'title', 'num', 'predata']
    }
</script>

<style scoped>
    .statistics-card {
        border-radius: 8px;
        overflow: hidden;
        flex: 1 1 auto;
        width: 20%;
        height: 133px;
        display: flex;
        justify-content: left;
        -webkit-box-shadow:0px 2px 15px rgba(0,0,0,0.08);
        -moz-box-shadow: 0px 2px 15px rgba(0,0,0,0.08);
        box-shadow: 0px 2px 15px rgba(0,0,0,0.08);
    }

    .statistics-card .statistics-card-info {
        display: flex;
        flex-direction: column;
        /*background: #1CC09F;*/
        width: 55%;
        top: auto;
        bottom: 23px;
    }

    .statistics-card .statistics-card-info >span {
        position: relative;
        left: 20px;
        display: block;
    }

    .statistics-card .statistics-card-info .card-info-title {

    }

    .statistics-card .statistics-card-info .card-info-num {

    }

    .statistics-card .statistics-card-graph {
        /*background: #7eff00;*/
        width: 45%;
        bottom: 23px;
    }
</style>