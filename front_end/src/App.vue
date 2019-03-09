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
          <a-icon type="user" />
          <span>nav 1</span>
        </a-menu-item>
        <a-menu-item key="2">
          <a-icon type="video-camera" />
          <span>nav 2</span>
        </a-menu-item>
        <a-menu-item key="3">
          <a-icon type="upload" />
          <span>nav 3</span>
        </a-menu-item>
      </a-menu>
    </a-layout-sider>
    <a-layout>
      <a-layout-header style="background: #fff; padding: 0">
        <a-icon
                class="trigger"
                :type="collapsed ? 'menu-unfold' : 'menu-fold'"
                @click="()=> collapsed = !collapsed"
        />
      </a-layout-header>
      <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff', minHeight: '280px' }">
        Content
      </a-layout-content>
    </a-layout>
    <!--<a-layout>-->
      <!--<a-layout-content>-->

      <!--</a-layout-content>-->
    <!--</a-layout>-->
    <div>
      <a-button type="primary" @click="showDrawer">
        Open
      </a-button>
      <a-drawer
              title="Multi-level drawer"
              width=520
              :closable="false"
              @close="onClose"
              :visible="visible"
      >
        <a-button type="primary" @click="showChildrenDrawer">
          Two-level drawer
        </a-button>
        <a-drawer
                title="Two-level Drawer"
                width=320
                :closable="false"
                @close="onChildrenDrawerClose"
                :visible="childrenDrawer"
        >
          <a-button type="primary" @click="showChildrenDrawer">
            This is two-level drawer
          </a-button>
        </a-drawer>
        <div
                :style="{
          position: 'absolute',
          bottom: 0,
          width: '100%',
          borderTop: '1px solid #e8e8e8',
          padding: '10px 16px',
          textAlign: 'right',
          left: 0,
          background: '#fff',
          borderRadius: '0 0 4px 4px',
        }"
        >
          <a-button
                  style="marginRight: 8px"
                  @click="onClose"
          >
            Cancel
          </a-button>
          <a-button @click="onClose" type="primary">
            Submit
          </a-button>
        </div>
      </a-drawer>
    </div>
  </a-layout>
</template>

<script>
    export default {
        data() {
            return {
                visible: false,
                childrenDrawer: false
            }
        },
        methods: {
            showDrawer() {
                this.visible = true
            },
            onClose() {
                this.visible = false
            },
            showChildrenDrawer() {
                this.childrenDrawer = true
            },
            onChildrenDrawerClose() {
                this.childrenDrawer = false
            },
        },
    }
</script>

<script>
    export default {
        data(){
            return {
                collapsed: false,
            }
        },
    }
</script>

<style>
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