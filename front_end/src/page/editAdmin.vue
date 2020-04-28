<template>
  <div class="container">
    <h1 class="title">设置管理员</h1>
    <div class="member-block">
      <member-card isEdit="true" v-for="item in members" :key="item.user_id" :member="item" @selectUser="handleSelectUser"></member-card>
    </div>
    <button class="btn-complete" @click="complete">完成</button>
  </div>
</template>

<script>
import memberCard from "../components/memberCard";
import { addGroup } from "../api/getData";

export default {
  name: "editAdmin",
  components: { memberCard },
  data() {
    return {
      members: this.$route.params.members
    }
  },
  mounted() {
    console.log(this.$route.params)
  },
  methods: {
    handleSelectUser: function(user_id) {
      const members = this.members;
      for (let i = 0; i < members.length; i++) {
        if (members[i].user_id === user_id) {
          if (members[i].identity) {
            this.members[i].identity = 0;
          } else {
            this.members[i].identity = 1;
          }
        }
      }
    },
    complete: function() {
      let user_id = [];
      this.members.forEach(item => {
        if (item.identity) {
          user_id.push({
            user_id: item.user_id,
            identity: 1
          })
        } else {
          user_id.push({
            user_id: item.user_id,
            identity: 0
          })
        }
      });
      addGroup({
        group_name: this.$route.params.groupName,
        avatar: this.$route.params.avatarUrl,
        desc: this.$route.params.groupDesc,
        join_code: this.$route.params.groupCode,
        user_id: user_id
      }).then(res => {
        console.log(res);
      })
    }
  }
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
.btn-complete {
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