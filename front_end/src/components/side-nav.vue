<template>
    <div id="side-bar">
        <!--<div class="side-bar-background">-->
            <div class="logo">
                <div style="position: relative;top: 5px">
                    <span style="font-size: 1.8em">@ </span>
                    <span style="font-size: 1.3em;">WUTOJ</span>
                </div>
            </div>
            <div class="menu-userbar" align="center">
                <div class="user-alias-border">
                    <div class="user-alias">
                        <!--<img src="../assets/logo.png" height="120" width="120"/>-->
                        <div style="background: #1CC09F;height: 100%;width:100%"></div>
                    </div>
                </div>
                <div class="user-info" align="center">
                    <span id="user-nick">Lomo Zheng</span>
                    <br>
                    <span id="user-desc">You blow me away.</span>
                </div>
                <div class="user-data">
                    <div class="data-item">
                        <strong>提交量</strong>
                        <br>
                        <strong id="submit-num">1214</strong>
                    </div>
                    <div class="data-item">
                        <strong>通过量</strong>
                        <br>
                        <strong id="ac-num">416</strong>
                    </div>
                    <div class="data-item">
                        <strong>正确率</strong>
                        <br>
                        <strong id="ac-percent">85%</strong>
                    </div>
                </div>
            </div>
            <div>
                <menu-item v-for="item in items"
                        :title="item.title"
                        :key="item.keyName"
                        :img-src="item.imgSrc"
                >
                </menu-item>
            </div>
            <div id="menu-footer" align="center">
                <span class="menu-footer-content">ACM@WUT</span>
                <span class="menu-footer-content">©2019 WUT ACM Developer</span>
            </div>
        <!--</div>-->
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
                items: [
                    {
                        title: '主页 Home',
                        keyNUm: '1',
                        imgSrc: '',
                        selected: true
                    },
                    {
                        title: '题目 Problems',
                        keyName: '2',
                        imgSrc: '',
                        selected: false
                    },
                    {
                        title: '比赛 Contests',
                        keyName: '3',
                        imgSrc: '',
                        selected: false
                    },
                    {
                        title: '排名 Rank',
                        keyName: '4',
                        imgSrc: '',
                        selected: false
                    },
                    {
                        title: '小组 Groups',
                        keyName: '5',
                        imgSrc: '',
                        selected: false
                    },
                ],
                selected: '1',
            }
        },
        mounted(){
            this.watchChild();
        },
        methods: {
            watchChild() {
                this.items.forEach(vm => {
                    vm.$on('menuItemUpdate', name => {
                        this.$emit('update:selected', [name])
                    });
                });
                alert('here');
            },
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
    }

    .side-bar-background {
        height: 100%;
        width: 100%;
        background: #fbfbfb;
        -webkit-box-shadow: 0px 0px 40px #fbfbfb;
        -moz-box-shadow: 0px 0px 40px #fbfbfb;
        box-shadow: 0px 0px 40px #fbfbfb;
    }

    .logo {
        align-items: center;
        text-align: center;
        height: 6.3%;
        /*background: #a94442;*/
    }

    .menu-userbar {
        text-align: center;
        height: 220px;
        /*background: #66512c;*/
    }

    .menu-userbar .user-alias-border {
        position: relative;
        left: 75px;
        top: 2%;
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
        font-size: 0.08em;
    }

    .menu-item {
        display: flex;
        flex-direction: row;
        justify-content: left;
        align-items: center;
        height: 60px;
        border-left: 5px solid transparent;
    }

    .menu-item-active {
        background: #f5f5f5;
        border-left: 5px #5c8db7 solid;
    }

    #menu-footer {
        float: top;
        width: 100%;
        display: block;
        position: absolute;
        bottom: 7px;
    }
    
    #menu-footer >span {
        display: block;
    }
</style>