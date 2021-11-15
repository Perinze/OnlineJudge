<template>
  <div class="rank">
    <span>星级排名:{{ rank }}</span>
    <div class="progressContainer">
      <div class="progressItem" :style="{ width: barwidth + '%' }"></div>
    </div>
    <span>{{ now }}/{{ total }}</span>
  </div>
</template>

<script>
export default {
  name: "progressbar",
  props: ["rank", "barwidth", "now", "total"],
};
</script>

<style scoped>
.rank {
  position: relative;
  width: 12%;
  padding: 80px 0 0 20px;
  text-align: left;
}

.progressContainer {
  position: relative;
  height: 10px;
  width: 100%;
  background-color: #aaa;
  border-radius: 5px;
}

.progressItem {
  position: absolute;
  height: 10px;
  width: 100%;
  background-color: orange;
  border-radius: 5px;
  border: 1px solid orange;
  background-image: linear-gradient(
    100deg,
    rgba(255, 255, 255, 0.15) 25%,
    transparent 25%,
    transparent 50%,
    rgba(255, 255, 255, 0.15) 50%,
    rgba(255, 255, 255, 0.15) 75%,
    transparent 75%,
    transparent
  );
}
</style>
