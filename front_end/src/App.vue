<template>
    <div>
        <top-nav></top-nav>
        <sidenav></sidenav>
        <layoutcontent :content="mainContent"></layoutcontent>
        <top-drawer>
            <!--<codemirror></codemirror>-->
        </top-drawer>
        <side-drawer></side-drawer>
    </div>
</template>

<script>
    import layoutcontent from "./components/layout-content"
    import sidenav from "./components/side-nav"

    export default {
        components: { layoutcontent ,sidenav },
        data() {
            return {
                topDrawerContent: 'codemirror',
                sideDrawerContent: 'probleminfo',
                mainContent: 'mainpage',
                blurNav: 'blur_nav',
                collapsed: false,
                visible: true,
                TopVisible: true,
            }
        },
        methods: {
            showDrawer() {
                this.visible = true
            },
            onClose() {
                this.visible = false
            },
            showTopDrawer() {
                this.TopVisible = true
            },
            onCloseTop() {
                this.TopVisible = false
            },
        },
    }
</script>

<style>

  /*TODO margin to % or width to px*/
  .ant-drawer-top .ant-drawer-wrapper-body {
    height: 100% !important;
  }

  .ant-drawer-top .ant-drawer-wrapper-body .ant-drawer-body {
    height: 100% !important;
  }

  .ant-drawer-top .ant-drawer-content-wrapper {
    width: 45% !important;
    margin-left: 7%;
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
  }

  .ant-drawer-top .ant-drawer-content {
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
  }

  .layout-content-fold {
    width: 51.2% !important;
    -webkit-transition: transifrom .3s;
    -moz-transition: transifrom .3s;
    -ms-transition: transifrom .3s;
    -o-transition: transifrom .3s;
    transition: transifrom .3s;
  }

  .ant-drawer-right .ant-drawer-content-wrapper {
    border-bottom-left-radius: 20px;
    border-top-left-radius: 20px;
  }

  .ant-drawer-right .ant-drawer-content {
    border-bottom-left-radius: 20px;
    border-top-left-radius: 20px;
  }

  .ant-drawer-close {
    left: 0;
    right: unset !important;
  }

  .ant-drawer-body {
    padding: 0 0 3px 0 !important;
    height: 100%;
  }

  #components-layout-demo-custom-trigger .trigger {
    font-size: 18px;
    line-height: 64px;
    padding: 0 24px;
    cursor: pointer;
    transition: color .3s;
  }

  #components-layout-demo-custom-trigger .trigger:hover {
    color: #1890ff;
  }

  #components-layout-demo-custom-trigger .logo {
    height: 32px;
    background: rgba(255,255,255,.2);
    margin: 16px;
  }
</style>

<!--TODO CodeMirror Theme: material nord oceanic-next-->