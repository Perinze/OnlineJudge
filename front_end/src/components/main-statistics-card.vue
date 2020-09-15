<template>
  <div class="statistics-card">
    <div class="statistics-card-info">
      <span class="card-info-title">{{ title }}</span>
      <span class="card-info-num">{{ num }}</span>
      <span class="card-precent-content">
        <img class="statistics-icon" />
        <span class="statistics-percent"></span>
      </span>
    </div>
    <div class="statistics-card-graph" v-if="predata.length > 1">
      <div
        class="graph-item"
        v-for="index in predata.length"
        v-bind:key="index"
        style="transition: height .6s ease;"
        :style="{
          height:
            ((predata[predata.length - index].num - numMin) /
              (numMax - numMin + 1)) *
              42 +
            2 +
            'px',
        }"
      ></div>
    </div>
    <div class="statistics-card-graph" v-else>
      <div
        class="graph-item"
        v-for="index in predata.length"
        v-bind:key="index"
        :style="{ height: index * 3.5 + 'px' }"
      ></div>
    </div>
  </div>
</template>

<script>
export default {
  name: "main-statistics-card",
  props: {
    title: {
      type: String,
      default: "Title",
    },
    num: {
      type: String,
      default: "",
    },
    predata: {
      type: Array,
      default: function() {
        return [
          {
            time: "",
            num: 0,
          },
        ];
      },
    },
  },
  computed: {
    numMax() {
      // TODO 之后调整为平均值
      var ans = 0;
      this.predata.forEach((val) => {
        if (val.num > ans) {
          ans = val.num;
        }
      });
      return ans;
    },
    numMin() {
      var ans = 9999999;
      this.predata.forEach((val) => {
        if (val.num < ans) {
          ans = val.num;
        }
      });
      return ans;
    },
  },
};
</script>

<style lang="scss" scoped>
.statistics-card {
  background: white;
  border-radius: 10px;
  overflow: hidden;
  // flex: 1 1 auto;
  width: 370px;
  height: 133px;
  display: flex;
  justify-content: flex-end;
  align-items: flex-end;
  box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.08);
}

.statistics-card .statistics-card-info {
  display: flex;
  flex: 1 1 auto;
  flex-direction: column;
  /*background: #1CC09F;*/
  width: 228px;
  top: auto;
  bottom: 23px;
  > span {
    position: relative;
    left: 20px;
    display: block;
  }
}

.statistics-card .statistics-card-info .card-info-title {
  width: 48px;
  height: 22px;
  margin-bottom: 18px;
  font-size: 16px;
  font-weight: 400;
  color: rgba(38, 38, 38, 1);
  opacity: 0.5;
}

.statistics-card .statistics-card-info .card-info-num {
  width: 150px;
  height: 30px;
  margin-bottom: 14px;
  font-size: 30px;
  font-weight: bold;
  line-height: 36px;
  color: rgba(77, 79, 92, 1);
  opacity: 1;
  text-align: left;
}

.statistics-card .statistics-card-info .card-precent-content {
  height: 11px;
  margin-bottom: 20px;
}

.statistics-card .statistics-card-graph {
  /*background: #7eff00;*/
  display: flex;
  flex-direction: row;
  align-items: flex-end;
  justify-content: flex-end;
  position: relative;
  width: 128px;
  right: 14px;
  bottom: 20px;
  height: 50px;
}

.statistics-card .statistics-card-graph .graph-item {
  background: linear-gradient(
    to bottom,
    rgba(140, 215, 253, 1),
    rgba(189, 234, 254, 1)
  );
  width: 8.9px;
  margin-right: 1px;
}
</style>
