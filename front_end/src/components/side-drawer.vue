<template>
  <div id="side-drawer" :style="marginRightStyleObject">
    <div class="close-btn" @click="close()">
      <img src="../../assets/icon/no.svg" width="15" height="15" alt="close" />
    </div>
    <problem-detail
      :pid="pid"
      :cid="cid"
      :key="'p=' + pid + '&c=' + cid"
      @open-submit="popOpenSubmit"
    />
  </div>
</template>

<script>
import problemDetail from "../page/problemDetail";
export default {
  name: "side-drawer",
  props: ["isDisplay", "pid", "cid", "windowResize"],
  components: {
    problemDetail,
  },
  methods: {
    close() {
      this.$emit("close");
    },
    popOpenSubmit(val) {
      this.$emit("open-submit", val);
    },
  },
  computed: {
    marginRightStyleObject() {
      let res = {
        "margin-right": 0,
      };
      let trick = this.windowResize;
      if (this.isDisplay) {
        // open
        res["margin-right"] = 0;
      } else {
        // hide
        let phantom = (this.$root.$el.clientWidth - 200) / 2;
        res["margin-right"] = `-${phantom}px`;
      }
      return res;
    },
  },
};
</script>

<style lang="scss" scoped>
#side-drawer {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: auto;
  width: calc((100% - 200px) / 2);
  background: white;
  z-index: 1001;
  border: {
    top-left-radius: 0.8em;
    bottom-left-radius: 0.8em;
  }
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.18);
  overflow-y: scroll;
  transition: margin-right 0.5s ease-in-out;
}

.close-btn {
  position: absolute;
  margin: 10px 0 0 15px;
  cursor: pointer;
  z-index: 1002;
}
</style>
