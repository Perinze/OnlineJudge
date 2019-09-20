<template>
    <div style="height: 100%;">
        <topnav :topnavOpacity="topnavOpacity" />
        <sidenav ref="sidenav" />
        <div class="layout-content" ref="parent">
            <keep-alive>
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
                // await this.getCombox();
                // this.combox = await document.getElementById('combox');
                // console.log(this.combox);
                // this.combox.addEventListener('scroll', () => {
                //     this.topnavOpacity = this.combox.scrollTop * 0.0033;
                // }, true);
                // setTimeout(() => {
                //     console.log(this.combox);
                // },2000);
                setTimeout(() => {
                    this.getCombox();
                    this.combox.addEventListener('scroll', () => {
                        this.topnavOpacity = this.combox.scrollTop * 0.0033;
                        console.log('here');
                    }, true);
                    console.log(this.combox);
                },2000);
                console.log(this.combox);
                // await sleep(100);
                // console.log(this.combox);
                // this.combox.addEventListener('scroll', () => {
                //     this.topnavOpacity = this.combox.scrollTop * 0.0033;
                // }, true);
                // setTimeout(() => {
                //     console.log(this.combox);
                // },3000);
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
</style>

<!--TODO CodeMirror Theme: material nord oceanic-next-->