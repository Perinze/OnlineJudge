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
      </a-menu>
    </a-layout-sider>
    <a-layout>
      <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff', minHeight: '280px' }">
        <!--TODO 写一个样式类，用transition ease 0.3s-->
        <!--TODO content-->
        {{ layoutContent }}
        <a-list
                :dataSource="[
        {
          name: 'Lily',
        },
        {
          name: 'Lily',
        },
      ]"
                bordered
        >
          <a-list-item slot="renderItem" slot-scope="item">
            <a slot="actions" @click="showDrawer">View Profile</a>
            <a-list-item-meta
                    description="Progresser AFX"
            >
              <a slot="title" href="https://vue.ant.design/">{{item.name}}</a>
              <a-avatar slot="avatar" src="https://gw.alipayobjects.com/zos/rmsportal/BiazfanxmamNRoxxVxka.png" />
            </a-list-item-meta>
          </a-list-item>
        </a-list>

      </a-layout-content>
      <a-drawer
              width=44%
              placement="right"
              :closable="true"
              @close="onClose"
              :visible="visible"
              :mask="false"
      >
        <iframe
                :srcdoc="drawerContent"
                frameborder="0"
                marginheight="0"
                marginwidth="0"
                scrolling=yes
                style="height: 100%;width: 100%;"
        >
        </iframe>
      </a-drawer>
      <a-layout-footer style="text-align: center">
        ACM@WUT © 2019 Created by WUT-ACM-Developer
      </a-layout-footer>
      <!--TODO a drawer from top to down upon a-layout-content(code input)-->
    </a-layout>
  </a-layout>
</template>

<script>
    export default {
        data() {
            return {
                collapsed: true,
                visible: false,
                drawerContent: "<p>123 Test</p>",
                layoutContent: "<p>layout test</p>"
            }
        },
        methods: {
            showDrawer() {
                this.visible = true
            },
            onClose() {
                this.visible = false
            },
        },
    }
</script>

<style>
  /*TODO 重写drawer样式，左侧加上圆角*/

  /*#layout-content-transition-with-trigger*/

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