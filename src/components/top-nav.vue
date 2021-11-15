<template>
  <div class="top-nav" :style="styleObject">
    <div class="search-bar" v-if="!isWap">
      <img src="../../assets/icon/search.svg" width="16px" height="16px" />
      <input
        type="text"
        class="search-input"
        placeholder="Search problem, contest or user"
      />
    </div>
    <div class="wap-bar" v-else>
      <!-- left icon -->
      <div class="left-icon" @click="$emit('call-side-bar')">
        <svg width="20px" height="16px" viewBox="0 0 20 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <title>icon</title>
            <g id="icon" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect id="矩形" stroke="#000000" fill="#D8D8D8" x="8.5" y="14.5" width="11" height="1" rx="0.5"></rect>
                <rect id="矩形" stroke="#07C793" fill="#D8D8D8" x="0.5" y="0.5" width="11" height="1" rx="0.5"></rect>
                <rect id="矩形" stroke="#000000" fill="#000000" x="0.5" y="7.5" width="19" height="1" rx="0.5"></rect>
            </g>
        </svg>
      </div>
      <!-- main content -->
      <div class="main-content">
        <div class="">WUTOJ</div>
      </div>
      <!-- right icon -->
      <div class="right-icon">
      </div>
    </div>
  </div>
</template>

<script>
import { judgeWap } from "../utils";

export default {
  name: "top-nav",
  props: ["topnavOpacity", "mineWidth"],
  computed: {
    styleObject() {
      if (this.isWap) {
        return {
          width: this.mineWidth,
          background: "rgb(255,255,255)",
          "box-shadow": "0 5px 20px rgba(0,0,0,0.08)",
        };
      }

      return {
        width: this.mineWidth,
        background: `rgba(255,255,255,${this.topnavOpacity})`,
      };
    },
    isWap() {
      return judgeWap();
    }
  },
};
</script>

<style lang="scss" scoped>
.top-nav {
  display: flex;
  flex-direction: column;
  position: fixed;
  height: 60px;
  z-index: 999;
  background: white;
  transition: background 0.1s ease 0s, width 0.5s ease-in;
  color: #888888;
}
.search-bar {
  margin: 0 auto;
  display: flex;
  align-items: center;
  position: relative;
  top: 13px;
  width: 90%;
  max-width: 1230px;
  height: 35px;
  border-radius: 17.5px;
  background: rgba(255, 255, 255, 0.3);
  > input,
  > input::placeholder,
  > img,
  & {
    transition: all 0.6s ease 0s;
  }
  &:hover {
    background: rgba(255, 255, 255, 0.5);
    > input::placeholder {
      color: #888888;
    }
  }
  &:focus,
  &:hover {
    > img {
      filter: invert(0.4);
    }
  }
  &:active {
    background: rgba(255, 255, 255, 0.5);
  }
  > img {
    position: absolute;
    left: 16px;
    filter: invert(0.8);
  }
  > input {
    display: unset;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0);
    border-radius: inherit;
    padding-left: 42px;
    border: none;
    outline: none;
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    &::placeholder {
      font-size: 15px;
      font-weight: 300;
      color: #bbbbbb;
    }
    &:focus::placeholder {
      color: #888888;
    }
  }
}
@media (max-width: 1543px) and (min-width: 1280px) {
  .search-bar {
    max-width: 996px;
    left: 13px;
  }
}

@media screen and (max-width: 650px) {
  .wap-bar {
    display: flex;
    flex-direction: row;
    align-items: center;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    width: 100%;
    height: 100%;
    padding: 10px 20px;
  }

  .wap-bar > .main-content {
    flex: 1 1 80%;
    text-align: center;
    font-size: 20px;
    font-weight: 600;
    font-family: PingFang SC;
    color: #4d4f5c;
  }

  .wap-bar > .left-icon, .right-icon {
    display: flex;
    align-items: center;
    width: 20px;
    height: 20px;
  }
}
</style>
