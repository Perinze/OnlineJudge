<template>
  <div class="container">
    <div class="basic">
      <div class="group-avatar-wrap">
        <!-- <div class="group-avatar"></div> -->
        <img :src="avatar" alt="" class="group-avatar" />
        <button class="btn-choose-avatar">
          选择群头像
          <input
            type="file"
            id="group-avatar-input"
            class="file-input"
            @change="chooseAvatar"
          />
        </button>
      </div>
      <div class="infos">
        <div class="info-item">
          <span class="info-item-label">姓名 :</span>
          <input type="text" class="info-item-input" />
        </div>
        <div class="info-item">
          <span class="info-item-label">群简介 :</span>
          <input type="text" class="info-item-input" />
        </div>
        <div class="info-item">
          <span class="info-item-label">加群码 :</span>
          <input type="text" class="info-item-input" />
        </div>
      </div>
    </div>
    <div class="member">
      <p class="member-title">添加成员</p>
      <div class="search">
        <svg
          t="1552933355466"
          class="icon"
          style
          viewBox="0 0 1024 1024"
          version="1.1"
          xmlns="http://www.w3.org/2000/svg"
          p-id="16778"
          xmlns:xlink="http://www.w3.org/1999/xlink"
          width="16"
          height="16"
        >
          <path
            d="M976.724714 897.502035c8.738122 10.239986 13.107183 21.572238 13.107183 33.996755a48.469269 48.469269 0 0 1-14.745581 35.566886 48.469269 48.469269 0 0 1-35.703419 14.813847 53.247929 53.247929 0 0 1-16.930111-2.730663 45.533806 45.533806 0 0 1-20.479972-13.789848l0.136533 1.228798-270.813506-272.793236a368.844308 368.844308 0 0 1-242.824209 67.925242 266.922311 266.922311 0 0 1-46.421272-8.055456c-45.533806-3.071996-105.608393-28.808495-155.10166-67.447376-30.037293-17.612777-70.997239-61.030319-101.717197-115.097447a350.2758 350.2758 0 0 1-47.103937-144.315541c2.79893 32.49489-3.071996-4.164261-3.481596-42.120477 0.273066 12.970649 0 4.915193 0-3.208529 0-22.801036 2.047997-45.124207 6.007459-66.832978 9.557321-59.664987 33.860222-114.619581 69.085774-160.836052 17.476243-32.767956 73.386569-82.807356 140.014747-113.322515-34.747687 14.199448 1.297065-5.461326 41.096479-19.387708a361.812851 361.812851 0 0 1 122.19717-20.821305A371.233638 371.233638 0 0 1 587.536966 43.009308a368.502975 368.502975 0 0 1 149.981667 143.086743c-12.56105-28.398895 13.516782 13.926381 31.402625 62.873516 17.954109 48.947135 25.873032 98.576935 23.620235 149.025934-2.867196 83.967888-31.743958 159.538987-86.630284 226.781565l271.90577 272.724969h-1.023998z m-241.254078-500.598799a306.380391 306.380391 0 0 0-22.664503-133.529422A309.930253 309.930253 0 0 0 631.091042 143.63424c27.989296 26.828764 9.147721 6.621858-12.356251-11.332251A322.55957 322.55957 0 0 0 475.784582 63.489281c34.065021 5.802659-12.014917-5.119993-60.620719-5.119993-13.107183 0-25.941299 0.819199-38.638882 2.321063a38.638882 38.638882 0 0 0-9.147721 1.092265L361.574601 62.806615a311.022519 311.022519 0 0 0-153.599795 70.314573c-31.812224 19.797307-73.727902 74.069235-95.436673 137.693683-2.730663-9.011188-17.54451 40.618613-20.13864 95.436673a309.930253 309.930253 0 0 0 30.173827 152.234463 308.974521 308.974521 0 0 0 128.409428 141.380079c-0.2048 7.37279 57.139124 33.928488 120.21744 41.983944 2.047997 4.027728 49.151934 6.621858 96.733738-1.433599a318.395309 318.395309 0 0 0 110.250519-41.574344c11.400518-2.18453 52.83833-33.860222 85.33322-73.181769-12.629316 20.957839 23.210636-23.415435 46.421271-74.751901-33.109289 58.914055-19.387707 37.956216-8.465055 15.291713 21.026105-40.27728 33.587155-87.995616 34.269821-138.512882l-0.273066 9.284255z"
            p-id="16779"
            fill="#B9B9B9"
          />
        </svg>
        <input
          v-model="memberNick"
          type="text"
          class="member-input"
          placeholder="输入成员昵称查找"
          ref="memberInput"
        />
      </div>
      <div class="member-block">
        <member-card
          isEdit="false"
          v-for="item in members"
          :key="item.user_id"
          :member="item"
          @removeCard="handleRemoveCard"
        ></member-card>
      </div>
    </div>
    <button class="btn-nextTip">下一步</button>
  </div>
</template>

<script>
import memberCard from "../components/memberCard";
import { uploadImage, searchUser } from "../api/getData";
import { formatImgUrl } from "../utils";
import { domain } from "../config/env";
export default {
  name: "addGroup",
  components: { memberCard },
  data() {
    return {
      avatar: "",
      memberNick: "",
      members: [],
    };
  },
  mounted() {
    document.onkeydown = (e) => {
      if (e.keyCode == 13 && this.$refs.memberInput == document.activeElement) {
        window.console.log(this.memberNick);
        this.search(this.memberNick);
      }
    };
  },
  methods: {
    chooseAvatar: function(e) {
      window.console.log(e);
      let formData = new FormData(),
        params = {};
      formData.append("image", e.target.files[0]);
      params = { isImage: true, image: formData };
      uploadImage(params).then((res) => {
        window.console.log(res);
        if (res.status === 0) {
          this.avatar = `${domain}/api${res.data.slice(2)}`;
        } else {
          this.$message({
            message: res.message,
            type: "error",
          });
        }
      });
    },
    search: function(nick) {
      searchUser({
        nick: nick,
      }).then((res) => {
        window.console.log(res);
        if (res.status === 0) {
          this.members = [...this.members, { ...res.data }];
        }
      });
    },
    handleRemoveCard: function(user_id) {
      for (let i = 0; i < this.members.length; i++) {
        if (this.members[i].user_id === user_id) {
          this.members.splice(i, 1);
          break;
        }
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.container {
  padding: 90px 100px;
}
.basic {
  display: flex;
  margin-bottom: 85px;
}
.group-avatar-wrap {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-right: 75px;
}
.group-avatar {
  width: 82px;
  height: 82px;
  background: rgba(245, 245, 245, 1);
  box-shadow: 0px 0px 11px 4px rgba(4, 0, 0, 0.1);
  border-radius: 50%;
  margin-bottom: 23px;
}
.btn-choose-avatar {
  width: 111px;
  height: 26px;
  background: rgba(66, 136, 206, 1);
  border-radius: 12px;
  font-size: 12px;
  font-weight: 400;
  color: rgba(255, 255, 255, 1);
  position: relative;
  overflow: hidden;
}
.file-input {
  position: absolute;
  width: 111px;
  height: 50px;
  top: -24px;
  left: 0;
  cursor: pointer;
}
.info-item {
  font-size: 14px;
  font-weight: 400;
  color: rgba(125, 125, 125, 1);
  margin-top: 12px;
}
.info-item-label {
  display: inline-block;
  width: 50px;
  margin-right: 15px;
}
.info-item-input {
  width: 393px;
  height: 29px;
  background: rgba(251, 251, 251, 1);
  border-radius: 15px;
  border: none;
  padding-left: 14px;
  padding-right: 14px;
}
.member {
  width: 100%;
}
.member-title {
  font-size: 15px;
  font-weight: bold;
  color: rgba(125, 125, 125, 1);
}
.search {
  width: 100%;
  height: 35px;
  background: rgba(251, 251, 251, 1);
  box-shadow: 0px 10px 20px 0px rgba(4, 0, 0, 0.06);
  border-radius: 18px;
  display: flex;
  align-items: center;
  padding-left: 26px;
  padding-right: 26px;
  margin-bottom: 27px;
}
.member-input {
  flex-grow: 1;
  margin-left: 10px;
  background: rgba(251, 251, 251, 1);
  font-size: 13px;
  font-weight: 400;
  color: rgba(185, 185, 185, 1);
}
.member-block {
  flex-grow: 1;
  background: rgba(251, 251, 251, 1);
  box-shadow: 0px 8px 25px 6px rgba(4, 0, 0, 0.06);
  border-radius: 10px;
  padding: 28px 25px;
}
.btn-nextTip {
  margin-top: 37px;
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
