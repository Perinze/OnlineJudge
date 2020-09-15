<template>
  <div :name="keyName">
    <div style="width: 40px;"></div>
    <img
      class="icon"
      :src="imgSrc"
      width="18px"
      height="19px"
      :class="{ 'icon-active': isActive }"
    />
    <div style="width: 20px;"></div>
    <span>{{ title }}</span>
  </div>
</template>

<script>
export default {
  name: "menu-item",
  data() {
    return {
      selected: false,
    };
  },
  props: ["imgSrc", "title", "keyName", "isActive"],
};
</script>

<style lang="scss" scoped>
.icon-active {
  filter: invert(1) sepia(1) saturate(2) hue-rotate(175deg);
}
</style>
