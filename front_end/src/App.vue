<template>
    <div style="height: 100%;">
        <topnav :topnavOpacity="topnavOpacity" ></topnav>
        <sidenav></sidenav>
        <div class="layout-content" ref="parent">
            <component :is="mainContent" id="combox"></component>
        </div>
        <top-drawer>
            <!--<codemirror></codemirror>-->
        </top-drawer>
        <side-drawer></side-drawer>
    </div>
</template>

<script>
    import topnav from "./components/top-nav"
    import sidenav from "./components/side-nav"
    import mainpage from "./components/mainpage"

    export default {
        components: { topnav, sidenav, mainpage },
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
            this.combox = document.getElementById('combox');
            this.combox.addEventListener('scroll', ()=>{
                this.topnavOpacity = this.combox.scrollTop * 0.003;
            });
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