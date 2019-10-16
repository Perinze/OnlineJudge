<template>
    <div id="side-bar">
        <welcome :display="displayWelcome&&(!isLogin)" @logged="recvLoginData" @close="displayWelcome=false;"/>
        <div class="logo">
            <div style="position: relative;top: 9px">
                <img src="../../assets/media/logo.png">
            </div>
        </div>
        <div class="menu-userbar" align="center">
            <div class="user-alias-border">
                <div class="user-alias">
                    <img src="../../assets/media/avator.png" height="40" width="40"/>
                </div>
            </div>
            <div class="user-info" align="center" v-if="isLogin">
                <span id="user-nick">{{userData.nick}}</span>
                <br>
                <span id="user-desc" @click="doLogout">{{userData.desc}}</span>
            </div>
            <div class="user-data" v-if="isLogin">
                <div style="width: 12px"></div>
                <div class="data-item">
                    <strong class="data-font">提交量</strong>
                    <br>
                    <strong id="submit-num" class="data-num">{{new Number(userData.acCnt) + new Number(userData.waCnt)}}</strong>
                </div>
                <div class="data-item">
                    <strong class="data-font">通过量</strong>
                    <br>
                    <strong id="ac-num"  class="data-num">{{userData.acCnt}}</strong>
                </div>
                <div class="data-item">
                    <strong class="data-font">正确率</strong>
                    <br>
                    <strong id="ac-percent" class="data-num">{{acPercent}}%</strong>
                </div>
                <div style="width: 5px"></div>
            </div>
            <div class="function-btn-group" v-show="!isLogin">
                <span id="unlog-guide">您还没登陆</span>
                <br>
                <button @click="displayWelcome = true;">注册/登录</button>
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
            <div id="surprise" hidden>
                ********

                WUT OnlineJudge 的所有贡献者

                王熠弘（2017 级）：业务逻辑、OnlineJudge 前端页面、主页
                李劲巍（2017 级）：业务逻辑、 及部分评测核心对接任务
                曾嘉豪（2017 级）：项目运维及评测核心对接任务
                黄 融（2018 级）：评测核心及其对接任务
                郑文伟（2017 级）：WUTOJ 的设计工作
                周景尧（2017 级）：OnlineJudge 前端页面
                冷 瑜（2016 级）：Python 爬虫部分
                刘福鑫（2017 级）：主页

                ********
            </div>
        </div>
    </div>
</template>

<script>
    import MenuItem from "./menu-item";
    import welcome from "../components/welcome";
    import { logout } from "../api/getData";
    import { mapGetters } from "vuex";
    import store from '../store';

    export default {
        components: { MenuItem, welcome },
        name: "side-nav",
        data() {
            return {
                items: [
                    {
                        title: '主页 Home',
                        keyName: "mainpage",
                        imgSrc: require('../../assets/icon/home.svg'),
                        routeName: "main"
                    },
                    {
                        title: '题目 Problem',
                        keyName: "problemlist",
                        imgSrc: require('../../assets/icon/problem.svg'),
                        routeName: "problem"
                    },
                    {
                        title: '比赛 Contest',
                        keyName: 'contestpage',
                        imgSrc: require('../../assets/icon/contest.svg'),
                        routeName: "contest"
                    },
                    {
                        title: '排名 Rank',
                        keyName: 'rank',
                        imgSrc: require('../../assets/icon/rank.svg'),
                        routeName: "rank"
                    },
                    {
                        title: '小组 Groups',
                        keyName: 'grouplist',
                        imgSrc: require('../../assets/icon/group.svg'),
                        routeName: "group"
                    },
                ],
                userinfo: {
                    avator: '/assets/media/avator.png',
                },
                displayWelcome: false
                // userData: {
                //     userId: '213',
                //     nick: 'Lemo Zheng',
                //     desc: 'You blow me away.',
                //     acCnt: 214,
                //     waCnt: 1654
                // }
            }
        },
        created() {
            this.initUser();
        },
        methods: {
            recvLoginData: function(data) {
                this.$store.dispatch("login/userInfoStorage", data);
                this.userinfo.isLogin = true;
            },
            doLogout: async function() {
                // this.$loading.open();
                // setTimeout(() =>{
                //     this.$loading.hide();
                // },5000)
                let response = await logout();
                if(response.status == 0) {
                    // ok
                    let procedure = new Promise( (resolve, reject) => {
                        localStorage.removeItem("Flag");
                        localStorage.removeItem("userId");
                        localStorage.removeItem("nick");
                        localStorage.removeItem("desc");
                        localStorage.removeItem("avator");
                        localStorage.removeItem("acCnt");
                        localStorage.removeItem("waCnt");
                        resolve();
                    });
                    procedure.then( (successMessage) => {
                        this.initUser();
                    });
                }else{
                    //error
                }
            },
            initUser() {
                let tmp = localStorage.getItem('Flag');
                if(tmp==="isLogin") {
                    store.state.login.isLogin = true;
                }else{
                    store.state.login.isLogin = false;
                }
                store.state.login.userId = localStorage.getItem("userId");
                store.state.login.nick = localStorage.getItem("nick");
                store.state.login.desc = localStorage.getItem("desc");
                store.state.login.avator = localStorage.getItem("avator");
                store.state.login.acCnt = localStorage.getItem("acCnt");
                store.state.login.waCnt = localStorage.getItem("waCnt");
            },
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
                return null;
            },
            acPercent: function() {
                let ac = new Number(this.userData.acCnt);
                let total = ac + new Number(this.userData.waCnt);
                if(total==0) {
                    return 0;
                }else{
                    return (ac/total).toFixed(3) * 100;
                }
            },
            ...mapGetters('login', {
                userData: 'userInfo',
                isLogin: 'isLogin'
            }),
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

    .function-btn-group {
        position: relative;
        top: 27px;
        /*margin-top: 50px;*/
    }

    .function-btn-group > button {
        background: #4288ce;
        border: none;
        border-radius: 1.5em;
        color: white;
        height: 28px;
        width: 150px;
        margin-top: 20px;
        cursor: pointer;
    }

    #unlog-guide {
        font-size: 13px;
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