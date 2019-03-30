<template>
    <div id="side-bar">
        <div class="logo">
            <div style="position: relative;top: 9px">
                <img src="../assets/logo.png">
            </div>
        </div>
        <div class="menu-userbar" align="center">
            <div class="user-alias-border">
                <div class="user-alias">
                    <img src="../assets/avator.png" height="40" width="40"/>
                </div>
            </div>
            <div class="user-info" align="center">
                <span id="user-nick">Lomo Zheng</span>
                <br>
                <span id="user-desc">You blow me away.</span>
            </div>
            <div class="user-data">
                <div style="width: 12px"></div>
                <div class="data-item">
                    <strong class="data-font">提交量</strong>
                    <br>
                    <strong id="submit-num" class="data-num">1214</strong>
                </div>
                <div class="data-item">
                    <strong class="data-font">通过量</strong>
                    <br>
                    <strong id="ac-num"  class="data-num">416</strong>
                </div>
                <div class="data-item">
                    <strong class="data-font">正确率</strong>
                    <br>
                    <strong id="ac-percent" class="data-num">100%</strong>
                </div>
                <div style="width: 5px"></div>
            </div>
        </div>
        <div>
            <menu-item
                    v-for="(item,index) in items"
                    :title="item.title"
                    :key="item.keyName"
                    :img-src="item.imgSrc"
                    :class="[activeIndex === index?'menu-item-active':'menu-item']"
                    :is-active="activeIndex === index"
                    @click.native="activeIndex = index;"
            >
            </menu-item>
        </div>
        <div id="menu-footer" align="center">
            <span class="menu-footer-content" style="font-size: 14px;font-weight: 300;">ACM@WUT</span>
            <span class="menu-footer-content" style="font-size: 10px;font-weight: 200;">©2019 WUT ACM Developer</span>
        </div>
    </div>
</template>

<script>
    import MenuItem from "./menu-item";

    export default {
        components: { MenuItem },
        name: "side-nav",
        data() {
            return {
                // TODO item selected
                activeIndex: 0,
                items: [
                    {
                        title: '主页 Home',
                        keyName: 'mainpage',
                        imgSrc: require('../assets/home.svg')
                    },
                    {
                        title: '题目 Problem',
                        keyName: '2',
                        imgSrc: require('../assets/problem.svg')
                    },
                    {
                        title: '比赛 Contest',
                        keyName: '3',
                        imgSrc: require('../assets/contest.svg')
                    },
                    {
                        title: '排名 Rank',
                        keyName: '4',
                        imgSrc: require('../assets/rank.svg')
                    },
                    {
                        title: '小组 Groups',
                        keyName: '5',
                        imgSrc: require('../assets/group.svg')
                    },
                ],
                selected: '1',
            }
        }

    }
</script>

<style scoped>
    #user-nick {
        font-weight: bold;
        font-size: 16px;
    }

    #user-desc {
        font-weight: 300;
        font-size: 10px;
    }

    #side-bar {
        box-shadow: 0 0 15px #888888;
        height: 100%;
        width: 200px;
        background: #fbfbfb;
        position: fixed;
        z-index: 1000;
    }

    .logo {
        align-items: center;
        text-align: center;
        height: 60px;
        /*background: #a94442;*/
    }

    .menu-userbar {
        text-align: center;
        height: 220px;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        /*background: #66512c;*/
    }

    .menu-userbar .user-alias-border {
        position: relative;
        left: 75px;
        top: 20px;
        border-radius: 25px;
        border: 1px solid #5c8db7;
        height: 50px;
        width: 50px;
    }

    .menu-userbar .user-alias-border .user-alias {
        position: relative;
        top: 4px;
        left: 4px;
        height: 40px;
        width: 40px;
        border-radius: 20px;
        overflow: hidden;
    }

    .menu-userbar .user-info {
        position: relative;
        top: 25px;
    }

    .menu-userbar .user-data {
        position: relative;
        top: 50px;
        display: flex;
    }

    .menu-userbar .user-data .data-item {
        flex: 1 1 auto;
    }

    .menu-footer-content {
        align-self: center;
        color: #4d4f5c;
        opacity: 0.4;
    }

    .menu-item {
        font-size: 12px;
        font-weight: 300;
        color: #a0a5ab;
        display: flex;
        flex-direction: row;
        justify-content: left;
        align-items: center;
        height: 60px;
        border-left: 7px solid transparent;
    }

    .menu-item:hover {
        background: #f5f5f5;
        border-left: 7px solid transparent;
    }

    .menu-item-active {
        font-size: 12px;
        font-weight: 300;
        color: #338bb8;
        display: flex;
        flex-direction: row;
        justify-content: left;
        align-items: center;
        height: 60px;
        background: #f5f5f5;
        border-left: 7px #5c8db7 solid;
    }

    .data-item .data-font {
        font-size: 12px;
        font-weight: 500;
    }

    .data-item .data-num {
        font-size: 22px;
        font-weight: 500;
    }

    #menu-footer {
        float: top;
        width: 100%;
        display: block;
        position: absolute;
        bottom: 3.4%;
    }
    
    #menu-footer >span {
        display: block;
    }
</style>