<template>
  <div class="custom-loading" v-show="show">
    <!--<transition name="fade">-->
    <!--<div class="breathe-div" v-show="show" key="fade-animation"></div>-->
    <!--</transition>-->
    <div class="loading-mask"></div>
    <div id="box">
      <!--<div class="filter-mix"></div>-->
      <div class="spinner">
        <div class="spinner-container container1">
          <div class="circle1" :style="styleObject"></div>
          <div class="circle2" :style="styleObject"></div>
          <div class="circle3" :style="styleObject"></div>
          <div class="circle4" :style="styleObject"></div>
        </div>
        <div class="spinner-container container2">
          <div class="circle1" :style="styleObject"></div>
          <div class="circle2" :style="styleObject"></div>
          <div class="circle3" :style="styleObject"></div>
          <div class="circle4" :style="styleObject"></div>
        </div>
        <div class="spinner-container container3">
          <div class="circle1" :style="styleObject"></div>
          <div class="circle2" :style="styleObject"></div>
          <div class="circle3" :style="styleObject"></div>
          <div class="circle4" :style="styleObject"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "loading",
  data() {
    return {
      show: false,
      progressColor: "#ff0000",
    };
  },
  computed: {
    styleObject: function() {
      return {
        background: this.progressColor,
      };
    },
  },
};
</script>

<style lang="scss" scoped>
/*.fade-leave-active, .fade-enter-active {*/
/*transition: opacity .3s ease;*/
/*}*/

/*.fade-enter, .fade-leave-to {*/
/*opacity: 0;*/
/*}*/

.custom-loading {
  position: fixed;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  z-index: 9999999999;
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
}

.loading-mask {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  /*background: rgba(34,33,53,0.6);*/
  /*background: rgba(0, 0, 0, 0.15);*/
}

#box {
  background-color: rgba(0, 0, 0, 0.15);
  border-radius: 20px;
  padding: 35px 35px;
}

// Mix Animation

/*.filter-mix {*/
/*transform: translate(-50%, -50%);*/
/*filter: contrast(20);*/
/*position: absolute;*/
/*top: 50%;*/
/*left: 50%;*/
/*width: 200px;*/
/*height: 200px;*/
/*background: rgba(255, 255, 255, .7);*/
/*backdrop-filter: blur(20px);*/
/*&::before {*/
/*content: "";*/
/*position: absolute;*/
/*width: 60px;*/
/*height: 60px;*/
/*border-radius: 50%;*/
/*background: #333;*/
/*top: 20px;*/
/*left: 35px;*/
/*z-index: 2;*/
/*filter: blur(6px);*/
/*box-sizing: border-box;*/
/*animation: filterBallMove 1.8s ease-out infinite;*/
/*}*/
/*&::after {*/
/*content: "";*/
/*position: absolute;*/
/*width: 40px;*/
/*height: 40px;*/
/*border-radius: 50%;*/
/*background: #3F51B5;*/
/*top: 30px;*/
/*right: 50px;*/
/*z-index: 2;*/
/*filter: blur(6px);*/
/*animation: filterBallMove2 1.8s ease-out infinite;*/
/*}*/
/*}*/

/*@keyframes filterBallMove {*/
/*50% {*/
/*left: 110px;*/
/*}*/
/*}*/

/*@keyframes filterBallMove2 {*/
/*50% {*/
/*right: 110px;*/
/*}*/
/*}*/

// 顶部LED呼吸灯条

/*.breathe-div {*/
/*position: fixed;*/
/*top: -4px;*/
/*left: 0;*/
/*right: 0;*/
/*width: 101%;*/
/*!*width: 50%;*!*/
/*height: 9px;*/
/*background-image: radial-gradient(#2b92d4 20%, transparent 75%);*/
/*!*border: 1px solid #2b92d4;*!*/
/*text-align: center;*/
/*margin: 0 auto;*/
/*!*box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);*!*/
/*z-index: 9999999999;*/
/*!*overflow: hidden;*!*/
/*opacity: 1;*/
/*-webkit-animation-timing-function: ease-in-out;*/
/*-webkit-animation-name: breathe;*/
/*-webkit-animation-duration: 1500ms;*/
/*-webkit-animation-iteration-count: infinite;*/
/*-webkit-animation-direction: alternate;*/

/*!*-webkit-mask-image: -webkit-radial-gradient(red 70%,transparent 100%);*!*/
/*}*/

/*@-webkit-keyframes breathe {*/
/*0% {*/
/*opacity: .3;*/
/*!*box-shadow: 0 1px 2px rgba(0, 147, 223, 0.4), 0 1px 1px rgba(0, 147, 223, 0.1) inset;*!*/
/*box-shadow: 4px 5px 10px radial-gradient(rgba(0, 147, 223, 0.4) 20%, transparent 75%);*/
/*}*/

/*100% {*/
/*opacity: 1;*/
/*!*border: 1px solid rgba(59, 235, 235, 0.7);*!*/
/*background-image: radial-gradient(#2b92d4 20%, transparent 75%);*/
/*!*box-shadow: 0 1px 30px #0093df, 0 1px 20px #0093df inset;*!*/
/*box-shadow: 10px 10px 30px radial-gradient(rgba(34,33,53,1) 50%, transparent 75%);*/
/*}*/
/*}*/

// Another Loading Animation
// 仿MicroSoft

.spinner {
  margin: 0 auto;
  width: 100px;
  height: 100px;
  position: relative;
}

.container1 > div,
.container2 > div,
.container3 > div {
  width: 20px;
  height: 20px;
  /*background-color: #333;*/

  border-radius: 100%;
  position: absolute;
  -webkit-animation: bouncedelay 1.2s infinite ease-in-out;
  animation: bouncedelay 1.2s infinite ease-in-out;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
}

.spinner .spinner-container {
  position: absolute;
  width: 100%;
  height: 100%;
}

.container2 {
  -webkit-transform: rotateZ(45deg);
  transform: rotateZ(45deg);
}

.container3 {
  -webkit-transform: rotateZ(90deg);
  transform: rotateZ(90deg);
}

.circle1 {
  top: 0;
  left: 0;
}
.circle2 {
  top: 0;
  right: 0;
}
.circle3 {
  right: 0;
  bottom: 0;
}
.circle4 {
  left: 0;
  bottom: 0;
}

.container2 .circle1 {
  -webkit-animation-delay: -1.1s;
  animation-delay: -1.1s;
}

.container3 .circle1 {
  -webkit-animation-delay: -1s;
  animation-delay: -1s;
}

.container1 .circle2 {
  -webkit-animation-delay: -0.9s;
  animation-delay: -0.9s;
}

.container2 .circle2 {
  -webkit-animation-delay: -0.8s;
  animation-delay: -0.8s;
}

.container3 .circle2 {
  -webkit-animation-delay: -0.7s;
  animation-delay: -0.7s;
}

.container1 .circle3 {
  -webkit-animation-delay: -0.6s;
  animation-delay: -0.6s;
}

.container2 .circle3 {
  -webkit-animation-delay: -0.5s;
  animation-delay: -0.5s;
}

.container3 .circle3 {
  -webkit-animation-delay: -0.4s;
  animation-delay: -0.4s;
}

.container1 .circle4 {
  -webkit-animation-delay: -0.3s;
  animation-delay: -0.3s;
}

.container2 .circle4 {
  -webkit-animation-delay: -0.2s;
  animation-delay: -0.2s;
}

.container3 .circle4 {
  -webkit-animation-delay: -0.1s;
  animation-delay: -0.1s;
}

@-webkit-keyframes bouncedelay {
  0%,
  80%,
  100% {
    -webkit-transform: scale(0);
  }
  40% {
    -webkit-transform: scale(1);
  }
}

@keyframes bouncedelay {
  0%,
  80%,
  100% {
    transform: scale(0);
    -webkit-transform: scale(0);
  }
  40% {
    transform: scale(1);
    -webkit-transform: scale(1);
  }
}
</style>
