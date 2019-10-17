<template>
    <div class="page404">
        <img src="../../assets/icon/404.svg" alt="404" width="270" id="404-icon">
        <div id="blank-div"></div>
        <div id="404-content">
            <span class="title-404">404</span>
            <span class="detail-en">看起来你好像迷路了呢</span>
            <span class="subdetail-en">请求网页不可访问哟</span>
            <!--<span class="detail">网页丢失</span>-->
            <div class="function-text" @click="$router.go(-1)">
                <span class="guide-text">回到上一页</span>
                <!-- 右箭头 -->
                <svg width="16px" height="11px" viewBox="0 0 16 11" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                        <g id="404" transform="translate(-499.000000, -429.000000)" stroke="#000000" stroke-width="2">
                            <g id="404-+-Looks-like-you’re-lo" transform="translate(170.000000, 164.000000)">
                                <g id="GO-TO-HOME-+-Line-+-Path-73" transform="translate(248.000000, 261.000000)">
                                    <g id="Line-+-Path-73" transform="translate(82.000000, 5.000000)">
                                        <path d="M0.5,4 L11.5453606,4" id="Line"></path>
                                        <polyline id="Path-73" points="9.41381836 0.0925292969 13.3696672 4.04837812 9.30577409 8.11227122"></polyline>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
                <!-- 右箭头 END -->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "page404"
    }
</script>

<style lang="scss" scoped>
    .page404 {
        width: 100%;
        height: 100%;
        padding-left: 18px;
        padding-bottom: 115px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
    }

    #blank-div {
        width: 10%;
    }

    .title-404 {
        font-family: DINCondensed;
        /*color: #1951FC;*/
        color: #4288ce;
        display: block;
        font-size: 155px;
        font-weight: bold;
        line-height: 140px;
    }

    .detail-en {
        font-family: DINCondensed;
        color: #212121;
        display: block;
        font-size: 28px;
        font-weight: bold;
        letter-spacing: 0.93px;
        /*line-height: 28px;*/
    }

    .subdetail-en {
        display: inline-block;
        font-family: dinnext;
        color: #ABB1BF;
        /*line-height: 18px;*/
    }

    .detail {
        display: block;
        font-size: 20px;
        /*font-weight: bold;*/
    }

    .function-text {
        cursor: pointer;
        > svg {
            margin-left: 7px;
        }
    }

    .guide-text {
        display: inline-block;
        font-family: DINCondensed;
        font-weight: bold;
        color: black;
        font-size: 15px;
        margin-top: 40px;
        letter-spacing: 0.2px;
    }

    @media screen and (max-height: 700px) {
        .page404 {
            padding-bottom: 70px;
        }
    }
</style>