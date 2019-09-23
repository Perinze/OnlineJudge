<template>
    <div id="side-bar">
        <div class="logo">
            <div style="position: relative;top: 9px">
                <img src="../assets/media/logo.png">
            </div>
        </div>
        <div class="menu-userbar" align="center">
            <div class="user-alias-border">
                <div class="user-alias">
                    <img v-bind:src="[userinfo.isLogin?userinfo.avator:'./src/assets/media/default-avator.png']" height="40" width="40"/>
                </div>
            </div>
            <div class="user-info" align="center">
                <span id="user-nick">Lomo Zheng</span>
                <br>
                <span id="user-desc">You blow me away.</span>
            </div>
            <div class="user-data" v-if="userinfo.isLogin">
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
            <div class="button-blank"></div>
            <menu-item
                    v-for="(item,index) in items"
                    :title="item.title"
                    :key="item.keyName"
                    :img-src="item.imgSrc"
                    :class="[activeIndex === index?'menu-item-active':'menu-item']"
                    :is-active="activeIndex === index"
                    @click.native="
                        $emit('changeContent',item.keyName);
                        $router.push('/'+item.routeName)
                    "
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
                items: [
                    {
                        title: '主页 Home',
                        keyName: "mainpage",
                        imgSrc: require('../assets/icon/home.svg'),
                        routeName: "main"
                    },
                    {
                        title: '题目 Problem',
                        keyName: "problemlist",
                        imgSrc: require('../assets/icon/problem.svg'),
                        routeName: "problem"
                    },
                    {
                        title: '比赛 Contest',
                        keyName: 'contestpage',
                        imgSrc: require('../assets/icon/contest.svg'),
                        routeName: "contest"
                    },
                    {
                        title: '排名 Rank',
                        keyName: 'rank',
                        imgSrc: require('../assets/icon/rank.svg'),
                        routeName: "rank"
                    },
                    {
                        title: '小组 Groups',
                        keyName: 'grouplist',
                        imgSrc: require('../assets/icon/group.svg'),
                        routeName: "group"
                    },
                ],
                userinfo: {
                    isLogin: false,
                    avator: '../assets/media/avator.png',
                }
            }
        },
        computed: {
            activeIndex: function() {
                let res = this.$route.path + "/";
                let path = res.slice(0, res.indexOf("/", 1));
                switch(path) {
                    case '/main': return 0;
                    case '/problem': return 1;
                    case '/contest': return 2;
                    case '/rank': return 3;
                    case '/group': return 4;
                    default: console.log('fault in side-nav component');
                }
            }
        }

    }
</script>

<style scoped>
    #side-bar {
        height: 100%;
        width: 200px;
        background: #fbfbfb;
        position: fixed;
        z-index: 1000;
        box-shadow:inset -10px 0 15px -15px rgba(0,0,0,0.3);
    }

    .logo {
        align-items: center;
        text-align: center;
        height: 60px;
    }

    .menu-userbar {
        text-align: center;
        height: 220px;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .menu-userbar .user-alias-border {
        position: relative;
        left: 75px;
        top: 20px;
        border-radius: 25px;
        border: 2px solid #5c8db7;
        height: 50px;
        width: 50px;
    }

    .menu-userbar .user-alias-border .user-alias {
        position: relative;
        top: 3px;
        left: 3px;
        height: 40px;
        width: 40px;
        border-radius: 20px;
        overflow: hidden;
    }

    .menu-userbar .user-info {
        position: relative;
        top: 25px;
    }

    .menu-userbar .user-info #user-nick {
        font-weight: bold;
        font-size: 16px;
    }

    .menu-userbar .user-info #user-desc {
        font-weight: 300;
        font-size: 10px;
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
        transform: translate3d(0, 0, 0);
        -webkit-transition: all .6s ease 0s;
        -moz-transition: all .6s ease 0s;
        -o-transition: all .6s ease 0s;
        transition: all .6s ease 0s;
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
        transform: translate3d(0, 0, 0);
        -webkit-transition: all .6s ease 0s;
        -moz-transition: all .6s ease 0s;
        -o-transition: all .6s ease 0s;
        transition: all .6s ease 0s;
        background: #f5f5f5;
        border-left: 7px solid transparent;
        box-shadow:inset -10px 0 15px -16px rgba(0,0,0,0.3);
    }

    .menu-item-active {
        font-size: 12px;
        font-weight: 400;
        color: #338bb8;
        display: flex;
        flex-direction: row;
        justify-content: left;
        align-items: center;
        height: 60px;
        background: #f5f5f5;
        border-left: 7px #5c8db7 solid;
        box-shadow:inset -10px 0 15px -16px rgba(0,0,0,0.3);
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

    /*TODO 660 warning*/
    
    @media (min-height: 695px) {
        .button-blank {
            width: 100%;
            height: 34px;
            max-height: 34px;
        }
    }
</style>