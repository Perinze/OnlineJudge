<template>
    <div id="app">
        <sidenav
                ref="sidenav"
                :is-display="sidebarDisplay"
                @close="closeSideBar"
                @call="callSideBar"
        />
        <div class="layout-content" id="layout-content" :style="contentWidthObject">
            <topnav :topnavOpacity="topnavOpacity" :mineWidth="topnavWidth"/>
            <keep-alive>
                <router-view
                        id="combox"
                        class="combox"
                        :key="$route.fullPath+localUserId"
                        @open-problem="callSideDrawer"
                />
            </keep-alive>
        </div>
        <topdrawer
                :pid="codeComponentData.pid"
                :cid="codeComponentData.cid"
                :is-display="topDisplay"
                @close="topDisplay=false"
                @close-all="topDisplay=false; sideDisplay=false"
        />
        <sidedrawer
                :pid="problemComponentData.pid"
                :cid="problemComponentData.cid"
                :window-resize="windowResize"
                :is-display="sideDisplay"
                @close="sideDisplay=false"
                @open-submit="callSubmit"
        />
        <!--<div style="z-index: 1001;backdrop-filter: blur(30px);width: 500px;height: 500px;position: absolute;left: 470px;top: 100px;" @click="windowResize = ~windowResize;topDisplay=true;"></div>-->
    </div>
</template>

<script>
    import topnav from "./components/top-nav";
    import sidenav from "./components/side-nav";
    import topdrawer from "./components/top-drawer";
    import sidedrawer from "./components/side-drawer";
    export default {
        components: {
            topnav,
            sidenav,
            sidedrawer,
            topdrawer
        },
        data() {
            return {
                bgsrc: "../assets/logo.png",
                topnavOpacity: 0,
                combox: null,
                topDisplay: false,
                sidebarDisplay: true, // 侧边导航栏
                sideDisplay: false, // 侧边drawer
                windowResize: true, // computed cache trick
                problemComponentData: {
                    pid: null,
                    cid: null
                },
                codeComponentData: {
                    pid: null,
                    cid: null,
                    height: 480,
                    code: '',
                    lang: 'text/x-csrc'
                }
            }
        },
        mounted() {
            this.initCombox();
            this.$refs.sidenav.$on('changeContent',() => {
                this.topnavOpacity = 0;
            });
            window.onresize = () => {
                this.windowResize = ~this.windowResize;
            };
            setTimeout( () => {
                this.windowResize = ~this.windowResize;
            }, 50);
            // TODO 检测宽度，小于某值后自动关闭侧边栏
            let clientWidth = this.$el.clientWidth;
            if(clientWidth<200+560) {
                this.closeSideBar();
            }
        },
        methods: {
            getCombox: function() {
                this.combox = document.getElementById('combox');
            },
            initCombox: async function() {
                setTimeout(() => {
                    this.getCombox();
                    this.combox.addEventListener('scroll', () => {
                        this.topnavOpacity = this.combox.scrollTop * 0.0033;
                    }, true); // true 事件捕获
                },500);
            },
            callSideDrawer: function(val) {
                this.problemComponentData.pid = val.pid;
                if(val.cid!==undefined) {
                    this.problemComponentData.cid = val.cid;
                }else{
                    this.problemComponentData.cid = null;
                }
                this.sideDisplay = true;
            },
            callSubmit: function(val) {
                this.codeComponentData.pid = val.pid;
                this.codeComponentData.cid = val.cid;
                this.codeComponentData.height = this.$root.$el.clientHeight * 0.95 - 95;
                this.topDisplay = true;
                // 指定CodeMirror Class加上style height
                document.getElementsByClassName('CodeMirror')[0].setAttribute('style', `height: ${this.codeComponentData.height}px;`);
            },
            // 打开侧边栏
            callSideBar: function(val) {
                this.sidebarDisplay = true;
            },
            // 收起侧边栏
            closeSideBar() {
                this.sidebarDisplay = false;
            }
        },
        computed: {
            nowPath: function() {
                return this.$route.path;
            },
            localUserId: function() {
                let ret = localStorage.getItem('userId');
                return ret;
            },
            contentWidthObject: function() {
                let trick = this.windowResize; // computed cache trick
                let phantom = this.$root.$el.clientWidth-(this.$root.$el.clientWidth-200)/2;
                return {
                    width: this.sideDisplay?`${phantom}px`:'100%',
                    'padding-left': this.sidebarDisplay?'200px':0
                };
            },
            topnavWidth: function() {
                let res = this.contentWidthObject.width;
                return this.sidebarDisplay?`calc(${res} - 200px)`:res;
            }
        },
        watch: {
            nowPath: function() {
                this.initCombox();
            }
        }
    }
</script>

<style lang="scss">
    $acColor: #80DFC5;
    $waColor: #F77669;
    $tleColor: #82B1FF;
    $mleColor: #DECB6B;
    $reColor: rgb(131, 118, 169);
    #app {
        width: 100%;
        height: 100%;
        padding: 0;
        overflow-x: hidden;
    }
    .layout-content {
        position: relative;
        padding-left: 200px;
        height: 100%;
        transition: width 0.5s ease-in,
        padding-left 0.5s ease-in-out;
    }
    .combox {
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        overflow-y: scroll;
        position: relative;
    }
    /*
        题目icon BEGIN
    */
    .ac-icon::before {
        content: 'A';
        color: $acColor;
    }
    .wa-icon::before {
        content: 'W';
        color: $waColor;
    }
    .tle-icon::before {
        content: 'T';
        color: $tleColor;
    }
    .mle-icon::before {
        content: 'M';
        color: $mleColor;
    }
    .other-icon::before {
        content: 'O';
        color: black;
    }
    .un-icon::before {
        content: '-';
        color: #8A8A8A;
    }
    /*
        题目icon END
    */
    /*
        固定色 BEGIN
    */
    .ac-color {
        color: $acColor;
    }
    .wa-color {
        color: $waColor;
    }
    .tle-color {
        color: $tleColor;
    }
    .mle-color {
        color: $mleColor;
    }
    .re-color {
        color: $reColor;
    }
    /*
        固定色END
    */
    :focus {
        outline: 0;
    }
    /*
        外部字体
    */
    @font-face {
        font-family: countdown;
        src: url("../assets/font/countdown.ttf");
    }
    @font-face {
        font-family: dinnext;
        /*src: url("../assets/font/DINNext.otf");*/
        src: url("../assets/font/DINNext_min.ttf");
    }
    @font-face {
        font-family: DINCondensed;
        /*src: url("../assets/font/DINCondensed.otf");*/
        src: url("../assets/font/DINCondensed_min.ttf");
    }
</style>

<!--CodeMirror Theme: material nord oceanic-next-->
