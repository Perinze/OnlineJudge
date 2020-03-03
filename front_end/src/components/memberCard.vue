<template>
  <div :class="['member-card', isEdit === 'true' ? 'member-card-edit' : '']">
    <img src="../../assets/media/delete.png" class="delete-icon" v-if="isEdit === 'false'" @click="remove" />
    <img
      :src="isSelected ? selectedIcon : unselectedIcon"
      class="select-icon"
      v-if="isEdit === 'true'"
      @click="toggleSelected"
    />
    <img :src="member && member.avatar ? `http://dev.acmwhut.com/api${member.avatar.slice(2)}` : ''" class="member-avatar">
    <p class="member-nick">{{member && member.nick ? member.nick : ""}}</p>
    <p class="member-email">{{member && member.mail ? member.mail : ""}}</p>
  </div>
</template>

<script>
import unselectedIcon from "../../assets/media/unselected.png";
import selectedIcon from "../../assets/media/selected.png";

export default {
  name: "memberCard",
  props: ["isEdit", "member"],
  data() {
    return {
      isSelected: false,
      unselectedIcon,
      selectedIcon
    };
  },
  methods: {
    toggleSelected: function() {
      this.isSelected = !this.isSelected;
    },
    remove: function() {
      this.$emit('removeCard', this.member.user_id);
    }
  }
};
</script>

<style lang="scss" scoped>
.member-card {
  width: 170px;
  height: 170px;
  background: rgba(237, 239, 243, 1);
  border-radius: 15px;
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 40px;
}
.member-card-edit {
  box-shadow: 0px 7px 9px 0px rgba(4, 0, 0, 0.1);
}
.delete-icon {
  width: 14px;
  height: 14px;
  position: absolute;
  top: 15px;
  right: 15px;
  cursor: pointer;
}
.select-icon {
  width: 14px;
  height: 14px;
  position: absolute;
  top: 15px;
  right: 15px;
  cursor: pointer;
}
.member-avatar {
  width: 57px;
  height: 57px;
  background: rgba(255, 255, 255, 1);
  box-shadow: 0px 0px 11px 1px rgba(4, 0, 0, 0.1);
  border-radius: 50%;
}
.member-nick {
  margin-top: 12px;
  margin-bottom: 2px;
  font-size: 17px;
  font-weight: 400;
  color: rgba(149, 149, 149, 1);
}
.member-email {
  margin: 0;
  font-size: 14px;
  font-weight: 400;
  color: rgba(170, 170, 170, 1);
}
</style>