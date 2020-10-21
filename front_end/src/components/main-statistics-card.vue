<template>
  <div class="statistics-card">
    <div class="card-row card-top">
      <div class="card-column card-title-box">
        <div class="card-subtitle">{{ subtitle | upperCase }}</div>
        <div class="card-title">{{ title }}</div>
      </div>
      <div class="card-column card-percent-box" v-if="percent !== 0">
        <img class="card-icon" :src="isRise ? cardIcon.rise : cardIcon.decent"/>
        <div class="card-percent" :class="isRise ? 'card-rise' : 'card-decent'">{{ percent | abs | formatPercent }}</div>
      </div>
    </div>
    <div class="card-row card-bottom"> {{ num | formatNum }} </div>
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
    subtitle: {
      type: String,
      default: "subtitle",
    },
    num: {
      type: Number,
      default: 0,
    },
    percent: {
      type: Number,
      default: 0,
    }
  },
  data() {
    return {
      cardIcon: {
        rise: require("../../assets/icon/arrow-up.svg"),
        decent: require("../../assets/icon/arrow-down.svg"),
      }
    }
  },
  computed: {
    isRise() {
      return this.percent > 0;
    }
  },
  filters: {
    upperCase(str) {
      return str.toUpperCase();
    },
    abs(num) {
      return Math.abs(num);
    },
    formatNum: function(num) {
      let res = (num || 0).toString();
      let result = "";
      while (res.length > 3) {
        result = "," + res.slice(-3) + result;
        res = res.slice(0, res.length - 3);
      }
      if (res) {
        result = res + result;
      }
      return result;
    },
    formatPercent(num) {
      return `${num.toFixed(1)}%`;
    }
  }
};
</script>

<style lang="scss" scoped>
.statistics-card {
  display: flex;
  flex-direction: column;
  flex-basis: 150px;
  flex-grow: 1;
  flex-shrink: 0;
  justify-content: space-between;
  width: 100%;
  height: 100px;
  padding: 15px;
  background-color: #FFF;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0,0,0,.1);
}

.card-top {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  width: 100%;
}

.card-title-box {
  display: flex;
  flex-direction: column;
  text-align: left;
  font-family: PingFang SC;
}

.card-subtitle {
  font-size: 12px; 
  font-weight: 300;
  height: 9px;
  color: #7D8184;
  transform: scale(0.5833333);
  margin-top: -3px;
  margin-bottom: 2px;
  margin-left: -23%;
}

.card-title {
  font-size: 16px;
  font-weight: 600;
}

.card-percent-box {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
}

.card-percent {
  font-size: 11px;
  font-family: PingFang SC;
  font-weight: 600;
  line-height: 9px;
}

.card-bottom {
  width: 100%;
  text-align: left;
  font-size: 22px;
  font-family: Arial;
  font-weight: bold;
  line-height: 25px;
}

.card-icon {
  width: 7px;
  height: 9px;
  border: none;
  margin-right: 3px;
}

.card-rise {
  color: #07C793;
}

.card-decent {
  color: #F03443;
}

@media screen and (max-width: 650px) {
  .statistics-card {
    height: 70px;
    padding: 10px;
  }

  .card-subtitle {
    transform: scale(0.5);
    margin-left: -35%;
  }

  .card-title {
    font-size: 12px;
    transform: scale(0.83333333);
    margin-left: -10%;
  }

  .card-bottom {
    font-size: 16px;
    font-weight: bold;
    line-height: 18px;
  }

  .card-percent-box {
    transform: scale(0.666667);
    margin-top: -4px;
  }
}
</style>
