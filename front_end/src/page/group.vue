<template>
  <div class="container">
    <group-card isAdd="false"></group-card>
    <group-card isAdd="true"></group-card>
  </div>
</template>

<script>
import groupCard from "../components/groupCard";

export default {
  name: "group",
  components: { groupCard }
};
</script>

<style lang="scss" scoped>
.container {
  padding-top: 130px;
  padding-left: 54px;
  padding-right: 54px;
  display: flex;
}
</style>