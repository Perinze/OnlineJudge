<template>
  <div class="container">
    <group-card isAdd="false" v-for="item in groups" :group="item"></group-card>
    <group-card isAdd="true"></group-card>
  </div>
</template>

<script>
import groupCard from "../components/groupCard";
import { addGroup, getUserGroups } from "../api/getData";

export default {
  name: "group",
  components: { groupCard },
  data() {
    return {
      groups: [{ name: "拖延与压榨", members: 120 }]
    };
  },
  mounted() {
    getUserGroups().then(res => window.console.log(res));
    // let userGroups = getUserGroups();
    // userGroups.then(res => console.log(res));
    // fetch("/api/oj/Group/user_get_all_group")
    //   .then(res => res.json())
    //   .then(resJson => console.log(resJson))
    //   .catch(err => console.log(err));
    // async function createGroup() {
    //   let promise = await addGroup({
    //     group_name: "开发小组",
    //     desc: "agroup."
    //   });

    //   console.log(promise);
    // }
    // createGroup();
  }
};
</script>

<style lang="scss" scoped>
.container {
  padding-top: 130px;
  padding-left: 54px;
  padding-right: 54px;
  display: flex;
  flex-wrap: wrap;
}
</style>