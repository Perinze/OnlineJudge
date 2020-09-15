<template>
  <div class="status-icon">
    <div class="icon">
      <img src="../../assets/icon/yes.svg" v-if="iconType === 'ac'" />
      <img src="../../assets/icon/no.svg" v-else-if="iconType === 'wa'" />
      <span style="font-weight: bold;" v-else>Try</span>
    </div>
    <span
      class="times"
      :class="[
        iconType === 'ac'
          ? 'ac-color'
          : iconType === 'wa'
          ? 'wa-color'
          : 'tle-color',
      ]"
      >{{ times }}</span
    >
  </div>
</template>

<script>
export default {
  name: "status-icon",
  props: ["iconType", "times"],
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
  position: absolute;
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
  margin-left: 15px;
  /*padding: 10px 0 0 15px;*/
}
</style>
