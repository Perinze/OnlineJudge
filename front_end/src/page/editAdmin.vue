<template>
  <div class="container">
    <h1 class="title">设置管理员</h1>
    <div class="member-block">
      <member-card isEdit="true"></member-card>
    </div>
    <button class="btn-nextTip">下一步</button>
  </div>
</template>

<script>
import memberCard from "../components/memberCard";

export default {
  name: "editAdmin",
  components: { memberCard },
  mounted() {}
};
</script>

<style lang="scss" scoped>
.container {
  padding: 55px 47px;
}
.title {
  font-size: 23px;
  font-weight: bold;
  color: rgba(125, 125, 125, 1);
  margin-top: 0;
  margin-bottom: 33px;
}
.member-block {
  height: 100%;
}
.btn-nextTip {
  float: right;
  width: 111px;
  height: 26px;
  background: rgba(66, 136, 206, 1);
  border-radius: 12px;
  font-size: 13px;
  font-weight: bold;
  color: rgba(255, 255, 255, 1);
}
</style>