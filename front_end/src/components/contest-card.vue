<template>
  <div class="contest-card" v-on:click="gotoLink('/contest/' + contestId)">
    <div>
      <div class="contest-card-info">
        <div class="contest-type">{{ contestType }}</div>
        <div class="contest-nick">{{ contestNick }}</div>
      </div>
      <div class="contest-card-num">{{ contestNum }}</div>
    </div>
  </div>

  <!-- <div class="contest-card-new">
    <div class="contest-info-trapezoid"></div>
    <div class="contest-info">
      <div class="contest-begin-status"></div>
      <div class="contest-info-content"></div>
    </div>
  </div> -->
</template>

<script>
export default {
  name: "contest-card",
  props: ["contestId", "contestType", "contestNick", "contestNum"],
  methods: {
    gotoLink(link) {
      this.$router.push(link);
    },
  },
};
</script>

<style lang="scss" scoped>
.contest-card {
  display: flex;
  align-items: flex-start;
  width: 228px;
  height: 137px;
  /* TODO 找个背景svg */
  /*background:rgba(80,161,204,0.3);*/
  background: url("../../assets/media/contest-mini.jpeg");
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
  margin: 0 10px 41px 11px;
  border-radius: 10px;
  overflow: hidden;
  > div {
    width: 100%;
    height: 100%;
    border-radius: 10px;
    overflow: hidden;
    backdrop-filter: blur(12px) brightness(123%);
  }
}

.contest-card-info {
  position: relative;
  padding: 0 13px;
  text-align: left;
  width: 100%;
  height: 49px;
  top: 74px;
  font: {
    size: 14px;
    weight: bold;
  }
  line-height: 17px;
  color: rgba(255, 255, 255, 1);
  .contest-type {
    font: {
      size: 23px;
      weight: 400;
    }
  }
  .contest-nick {
    margin-top: 9px;
  }
}

.contest-card-num {
  position: relative;
  margin: -39px 12px 0 auto;
  width: 37px;
  height: 20px;
  font: {
    size: 14px;
    weight: 600;
  }
  line-height: 20px;
  color: rgba(255, 255, 255, 1);
}

.contest-card-new {
  display: flex;
  flex-direction: row;
  width: 314px;
  height: 130px;
  border-radius: 15px;
  overflow: hidden;
  margin: 0 10px 25px 11px;
  background: {
    position: right;
    image: url('../../assets/media/contest-mini.jpeg');
    size: calc(50% + 15px) 100%;
    repeat: no-repeat;
  }
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
}

.contest-info-trapezoid {
  width: 50%;
  height: 100%;
  border-radius: 15px;
  transform-origin: 0% 0%;
  transform: perspective(400px) rotateX(35deg);
  background-color: #FFF;
  overflow: hidden;
}

.contest-info {
  position: absolute;
  width: calc(314px * 50%);
  height: 130px;
}

.contest-begin-status {
  position: absolute;
  width: 60px;
  height: 20px;
  background: #CCC;
  border-top-left-radius: 15px;
  border-bottom-right-radius: 15px;
}

@media screen and (max-width: 650px) {
  .contest-card {
    width: 100%;
    margin: 0;

    .contest-card-info {
      left: 0;
      width: 100%;
      padding: 0 13px;
      text-align: left;
    }
  }

  .contest-card-new {
    width: 100%;
    height: 118px;
    
    .contest-info {
      position: absolute;
      width: 50%;
      height: 118px;
    }

    .contest-info-trapezoid {
      transform: perspective(370px) rotateX(35deg);
    }
  }
}
</style>
