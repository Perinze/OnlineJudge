<template>
    <div id="app">
        <sidenav ref="sidenav"/>
        <div class="layout-content" id="layout-content" :style="contentWidthObject">
            <topnav :topnavOpacity="topnavOpacity" :parentWidth="contentWidthObject.width"/>
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
            @change-lang="changeLang"
        >
            <code-editor
                ref="codeEditor"
                :lang="codeComponentData.lang"
                :precode="codeComponentData.code"
                :expectHeight="codeComponentData.height"
            />
        </topdrawer>
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
    import codeEditor from "./components/myCodemirror";

    export default {
        components: {
            topnav,
            sidenav,
            sidedrawer,
            topdrawer,
            codeEditor
        },
        data() {
            return {
                bgsrc: "../assets/logo.png",
                topnavOpacity: 0,
                combox: null,
                topDisplay: false,
                sideDisplay: false,
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
                if(val.pid !== this.codeComponentData.pid) {
                    this.codeComponentData.code = '';
                    this.$refs.codeEditor.code = '';
                }
                this.codeComponentData.pid = val.pid;
                this.codeComponentData.cid = val.cid;
                this.codeComponentData.height = this.$root.$el.clientHeight * 0.95 - 65;
                this.topDisplay = true;
                // 指定CodeMirror Class加上style height
                document.getElementsByClassName('CodeMirror')[0].setAttribute('style', `height: ${this.codeComponentData.height}px;`);
            },
            changeLang(val) {
                if(val==null || val==undefined) this.codeComponentData.lang = 'text/x-csrc';
                else this.codeComponentData.lang = val;
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
                let res = {
                    width: '100%'
                };
                let trick = this.windowResize;
                // computed cache trick
                if(this.sideDisplay) {
                    let phantom = this.$root.$el.clientWidth-(this.$root.$el.clientWidth-200)/2;
                    res.width = `${phantom}px`;
                }else{
                    res.width = '100%';
                }
                return res;
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
        transition: width 0.5s ease-in;
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