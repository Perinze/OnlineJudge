<template>
    <div style="height: 100%;">
        <topnav :topnavOpacity="topnavOpacity" />
        <sidenav ref="sidenav" />
        <div class="layout-content" ref="parent">
            <keep-alive exclude="temp-problem-detail,contestpage,contest-rank,discusslist,discussdetail,submitpage,submitdetail">
                <router-view id="combox" class="combox" />
            </keep-alive>
        </div>
        <!--<top-drawer />-->
            <!--<codemirror></codemirror>-->
        <sidedrawer />
        <!--<div class="test" style="z-index: 1001;-webkit-backdrop-filter: blur(30px);backdrop-filter: blur(30px);width: 500px;height: 500px;position: absolute;left: 100px;top: 100px;"></div>-->
    </div>
</template>

<script>
    import topnav from "./components/top-nav"
    import sidenav from "./components/side-nav"
    import sidedrawer from "./components/side-drawer"
    import mainpage from "./page/mainpage"
    import problemlist from "./page/problemlist"
    import contestpage from "./page/contestlist"

    export default {
        components: { topnav, sidenav, mainpage, problemlist, contestpage, sidedrawer },
        data() {
            return {
                topDrawerContent: 'codemirror',
                sideDrawerContent: 'probleminfo',
                mainContent: 'mainpage',
                bgsrc: "../assets/logo.png",
                topnavOpacity: 0,
                parent: null,
                combox: null,
            }
        },
        mounted() {
            this.initCombox();
            this.$refs.sidenav.$on('changeContent',(name)=>{
                this.mainContent = name;
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
                    }, true);
                },500);
            }
        },
        computed: {
            nowPath: function() {
                return this.$route.path;
            }
        },
        watch: {
            nowPath: function(val) {
                this.initCombox();
            }
        }
    }
</script>

<style>
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
        color: limegreen;
    }

    .wa-icon::before {
        content: 'W';
        color: #e94040;
    }

    .tle-icon::before {
        content: 'T';
        color: dodgerblue;
    }

    .mle-icon::before {
        content: 'M';
        color: darkorange;
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
        color: limegreen;
    }

    .wa-color {
        color: #e94040;
    }

    .tle-color {
        color: dodgerblue;
    }

    .mle-color {
        color: darkorange;
    }

    .ac-background {
        background: limegreen;
    }

    .wa-background {
        background: #e94040;
    }

    .tle-background {
        background: dodgerblue;
    }

    .mle-background {
        background: darkorange;
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
</style>

<!--TODO CodeMirror Theme: material nord oceanic-next-->