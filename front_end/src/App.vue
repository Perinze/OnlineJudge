<template>
    <div style="height: 100%;">
        <topnav :topnavOpacity="topnavOpacity" ></topnav>
        <sidenav ref="sidenav"></sidenav>
        <div class="layout-content" ref="parent">
            <keep-alive>
                <component :is="mainContent" id="combox"></component>
            </keep-alive>
        </div>
        <top-drawer>
            <!--<codemirror></codemirror>-->
        </top-drawer>
        <side-drawer></side-drawer>
        <!--<div class="test" style="z-index: 1001;-webkit-backdrop-filter: blur(30px);backdrop-filter: blur(30px);width: 500px;height: 500px;position: absolute;left: 100px;top: 100px;"></div>-->
    </div>
</template>

<script>
    import topnav from "./components/top-nav"
    import sidenav from "./components/side-nav"
    import mainpage from "./page/mainpage"
    import problemlist from "./page/problemlist"

    export default {
        components: { topnav, sidenav, mainpage, problemlist },
        data() {
            return {
                topDrawerContent: 'codemirror',
                sideDrawerContent: 'probleminfo',
                mainContent: 'mainpage',
                bgsrc: "../assets/logo.png",
                topnavOpacity: 0,
                parent: null,
                combox: null
            }
        },
        mounted() {
            this.initCombox();
            this.$refs.sidenav.$on('changeContent',(name)=>{
                this.mainContent = name;
                this.topnavOpacity = 0;
            })
        },
        methods: {
            initCombox: function() {
                this.combox = document.getElementById('combox');
                this.combox.addEventListener('scroll', ()=>{
                    this.topnavOpacity = this.combox.scrollTop * 0.0033;
                });
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
</style>

<!--TODO CodeMirror Theme: material nord oceanic-next-->