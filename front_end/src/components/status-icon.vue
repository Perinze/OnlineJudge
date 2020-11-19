<template>
  <div class="status-icon">
    <div class="icon">
      <span style="font-weight: bold;" v-if="frozen">Try</span>
      <img src="../../assets/icon/yes.svg" v-else-if="iconType === 'ac'"/>
      <img src="../../assets/icon/no.svg" v-else-if="iconType === 'wa'"/>
    </div>
    <span class="times" :class="colorClass">{{ times }}</span>
  </div>
</template>

<script>
export default {
  name: "status-icon",
  props: {
    iconType: {
      type: "ac" | "wa",
      require: true
    },
    times: {
      type: Number,
      require: true
    },
    frozen: {
      type: Boolean,
      default: false
    },
    firstBlood: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    colorClass() {
      if (this.frozen) {
        return "tle-color";
      }

      switch (this.iconType) {
        case "ac":
          if (this.firstBlood) {
            return "tle-color";
          }
          return "ac-color";
        case "wa":
          return "wa-color";
        default:
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.status-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  padding-right: 3px;
  margin-left: 2px;
  width: 100%;
  height: 100%;
}

.icon {
  > img {
    width: 20px;
    height: 20px;
  }
}

.times {
  position: relative;
  font-size: 12px;
  font-weight: bold;
  top: 9px;
  left: 0;
  bottom: 0;
  margin-left: -4px;
  /*padding: 10px 0 0 15px;*/
}
</style>
