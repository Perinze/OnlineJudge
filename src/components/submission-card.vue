<template>
  <div class="submission-card" @click="$router.push(`/status??p=${problemId}&s=${runid}`)">
    <!--
    <img
      class="avatar"
      :src="realAvatar"
      :alt="nick" 
      @click.stop="callUserCard"
    >
    -->
    <img
      class="avatar"
      :src="testAvator"
      @click.stop="callUserCard"
    >
    <div class="submission-info">
      <div class="run-info">
        <div><span class="info-title problem-id" @click.stop="$emit('call-problem', problemId)">P{{ problemId }}</span></div>
        <div><span class="info-title" :class="statusClass">{{ status }}</span></div>
        <div>
          <span class="info-title">Language: </span>
          <span class="info-content">{{ language | langDisplay }}</span>
        </div>
        <div class="wap-no-display">
          <span class="info-title">TimeCost: </span>
          <span class="info-content">{{ timeCost | timeCostFilter }}</span>
        </div>
        <div class="wap-no-display">
          <span class="info-title">MemoryCost: </span>
          <span class="info-content">{{ memory | memoryFilter }}</span>
        </div>
      </div>
      <div class="user-info">
        <div><span class="info-title">{{ nick }}</span></div>
        <div class="wap-no-display">
          <span class="info-title">Runid: </span>
          <span class="info-content">{{ runid }}</span>
        </div>
        <div class="wap-no-display">
          <span class="info-title">Submit-Time: </span>
          <span class="info-content">{{ time }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { languages } from "../config/language";

export default {
  name: "submission-card",
  testAvator:  require("../../assets/media/avator.png"),
  props: {
    // user
    userId: Number,
    avatar: String,
    nick: String,
    // submitInfo
    runid: Number,
    timeCost: Number,
    memory: Number,
    status: String,
    time: String,
    language: String,
    // problem
    problemId: Number,
  },
  methods: {
    callUserCard() {
    },
  },
  created(){
    this.testAvator = require("../../assets/media/avator.png");
  },
  computed: {
    realAvatar() {
      if (this.avatar === "null") {
        return require("../../assets/media/avator.png");
      }
      return this.avatar;
    },
    statusClass() {
      return `${this.status.toLowerCase()}-color`;
    }
  },
  filters: {
    timeCostFilter(val) {
      let res = parseInt(val); // ns
      res /= 1000000; // ms
      return parseInt(res) + " ms";
    },
    memoryFilter(val) {
      let res = parseInt(val); // byte
      res /= 1024.0 * 1024.0;
      if (res <= 0.01) {
        res *= 1024;
        res = res.toFixed(2);
        return res + " Kb";
      }
      res = res.toFixed(2);
      return res + " Mb";
    },
    langDisplay(val) {
      const len = languages.length;
      for (let i=0; i<len; i++) {
        if (val === languages[i].value) {
          return languages[i].name;
        }
      }
      return "Unknown Language";
    }
  }
}
</script>

<style lang="scss" scoped>
  .submission-card {
    display: flex;
    flex-direction: row;
    background-color: #FFF;
    width: 100%;
    height: 70px;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: background-color 200ms ease-in-out;
    cursor: pointer;

    &:hover {
      background-color: #F0F0F0;
    }
  }

  .avatar {
    width: 40px;
    height: 40px;
    border-radius: 100%;
    margin-right: 12px;
  }

  .submission-info {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .user-info, .run-info {
    display: flex;
    flex-direction: row;
    & > * {
      margin-right: 15px;
    }
  }

  .info-title {
    font-weight: bolder;
  }

  .problem-id:hover {
    text-decoration: underline;
  }

  @media screen and (max-width: 650px) {
    .submission-card {
      padding: 10px;
      height: 60px;
    }

    .avatar {
      margin-right: 10px;
    }

    .wap-no-display {
      display: none;
    }

    .user-info, .run-info > * {
      margin-right: 10px;
    }
  }
</style>