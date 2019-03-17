<template>
  <a-layout id="components-layout-demo-custom-trigger" style="height: 100%">
    <a-layout-sider
            :trigger="null"
            collapsible
            v-model="collapsed"
    >
      <div class="logo" />
      <a-menu theme="dark" mode="inline" :defaultSelectedKeys="['1']">

        <a-menu-item key="1">
          <a-icon type="home" />
          <span>主页</span>
        </a-menu-item>

        <a-menu-item key="2">
          <a-icon type="profile" />
          <span>题目</span>
        </a-menu-item>

        <a-menu-item key="3">
          <a-icon type="flag" />
          <span>比赛</span>
        </a-menu-item>

        <a-menu-item key="4">
          <a-icon type="bars" />
          <span>Rank</span>
        </a-menu-item>

        <a-menu-item key="5">
          <a-icon type="team" />
          <span>小组</span>
        </a-menu-item>

        <a-menu-item key="6">
          <a-icon type="user" />
          <span>用户</span>
        </a-menu-item>

      </a-menu>
    </a-layout-sider>
    <a-layout>
      <!--topDrawer-->
      <a-drawer
              :closable="false"
              placement="top"
              @close="onCloseTop"
              :visible="TopVisible"
              :mask="true"
              z-index="999"
              style="width: 40%"
              height=94%
      >
        <!--<keep-alive>-->
          <component :is="topDrawerContent"></component>
        <!--</keep-alive>-->
      </a-drawer>
      <a-layout-content
              :style="{ margin: '20px 16px', padding: '0px', background: '#fff', minHeight: '280px' }"
              :class="[visible?'layout-content-fold':'']"
      >
        <component :is="mainContent"></component>
      </a-layout-content>
      <!--leftDrawer-->
      <a-drawer
              width=44%
              placement="right"
              :closable="true"
              @close="onClose"
              :visible="visible"
              :mask="false"
              style="height: 100%;"
      >
        <keep-alive>
          <component :is="sideDrawerContent"></component>
        </keep-alive>
      </a-drawer>
      <a-layout-footer
              style="text-align: center"
              :class="[visible?'layout-content-fold':'']"
      >
        ACM@WUT © 2019 Created by WUT-ACM-Developer
      </a-layout-footer>
    </a-layout>
  </a-layout>
</template>

<script>
    import codemirror from "./components/codemirror"

    export default {
        components: {codemirror},
        data() {
            return {
                topDrawerContent: 'codemirror',
                collapsed: true,
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

  /*#layout-content-transition-with-trigger*/

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