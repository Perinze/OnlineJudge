<template>
    <div style="height: 100%;">
        <topnav :topnavOpacity="topnavOpacity" />
        <sidenav ref="sidenav"/>
        <div class="layout-content">
            <keep-alive>
                <router-view id="combox" class="combox" :key="$route.fullPath+localUserId"/>
            </keep-alive>
        </div>
        <!--<top-drawer />-->
        <sidedrawer :is-display="sideDisplay" @close="sideDisplay=false"/>
        <!--<div style="z-index: 1001;backdrop-filter: blur(30px);width: 500px;height: 500px;position: absolute;left: 470px;top: 100px;"></div>-->
    </div>
</template>

<script>
    import topnav from "./components/top-nav";
    import sidenav from "./components/side-nav";
    import sidedrawer from "./components/side-drawer";

    export default {
        components: {
            topnav,
            sidenav,
            sidedrawer
        },
        data() {
            return {
                bgsrc: "../assets/logo.png",
                topnavOpacity: 0,
                combox: null,
                sideDisplay: true
            }
        },
        mounted() {
            this.initCombox();
            this.$refs.sidenav.$on('changeContent',() => {
                this.topnavOpacity = 0;
            });
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
            }
        },
        computed: {
            nowPath: function() {
                return this.$route.path;
            },
            localUserId: function() {
                let ret = localStorage.getItem('userId');
                return ret;
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

    .layout-content {
        position: relative;
        padding-left: 200px;
        width: 100%;
        height: 100%;
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