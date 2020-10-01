<template>
  <div class="group-card">
    <div class="btn-submenu" @click="toggleSubmenu">
      <img class="btn-submenu-img" src="../../assets/media/submenu-pots.png" />
      <div :class="['submenu', isSubmenuActive ? 'submenu-active' : '']">
        <button class="submenu-item btn-dismiss" @click="dismiss">
          解散小组
        </button>
        <button class="submenu-item btn-edit" @click="edit">
          修改小组信息
        </button>
      </div>
    </div>
    <div class="group-avatar"></div>
    <p class="group-name" v-if="isAdd === 'false'">{{ group.name }}</p>
    <p class="group-member-num" v-if="isAdd === 'false'">
      {{ `${group.members}人` }}
    </p>
    <button class="btn-add" v-if="isAdd === 'true'" @click="toAdd">
      创建小组
    </button>
  </div>
</template>

<script>
export default {
  name: "groupCard",
  props: ["isAdd", "group"],
  data() {
    return {
      isSubmenuActive: false,
    };
  },
  methods: {
    toggleSubmenu: function() {
      this.isSubmenuActive = !this.isSubmenuActive;
    },
    dismiss: function() {},
    edit: function() {},
    toAdd: function() {
      this.$router.push("/addGroup");
    },
  },
};
</script>

<style lang="scss" scoped>
.group-card {
  width: 199px;
  height: 199px;
  background: rgba(237, 239, 243, 1);
  box-shadow: 0px 7px 9px 0px rgba(4, 0, 0, 0.1);
  border-radius: 15px;
  margin: 13px;
  padding-top: 47px;
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  align-items: center;
}
.btn-submenu {
  top: 20px;
  right: 20px;
  position: absolute;
}
.btn-submenu-img {
  width: 5px;
  height: 22px;
  cursor: pointer;
}
.btn-add {
  width: 100px;
  height: 26px;
  margin-top: 20px;
  background: rgba(66, 136, 206, 1);
  border-radius: 6px;
  font-size: 13px;
  font-weight: 400;
  color: rgba(255, 255, 255, 1);
}
.submenu {
  position: absolute;
  top: 23px;
  right: 0;
  visibility: hidden;
}
.submenu-active {
  visibility: visible;
}
.submenu-item {
  width: 100px;
  height: 26px;
  border-radius: 6px;
}
.btn-dismiss {
  background: rgba(170, 170, 170, 1);
  font-size: 13px;
  font-weight: 400;
  color: rgba(255, 255, 255, 1);
  margin-bottom: 2.5px;
}
.btn-edit {
  background: rgba(66, 136, 206, 1);
  font-size: 13px;
  font-weight: 400;
  color: rgba(255, 255, 255, 1);
}
.group-avatar {
  width: 66px;
  height: 66px;
  background: rgba(255, 255, 255, 1);
  box-shadow: 0px 0px 11px 1px rgba(4, 0, 0, 0.1);
  border-radius: 50%;
}
.group-name {
  margin-top: 16px;
  margin-bottom: 2px;
  font-size: 18px;
  font-weight: 400;
  color: rgba(149, 149, 149, 1);
}
.group-member-num {
  margin: 0;
  font-size: 17px;
  font-weight: 400;
  color: rgba(170, 170, 170, 1);
}
</style>
