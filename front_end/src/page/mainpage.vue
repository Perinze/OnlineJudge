<template>
  <div class="mainpage">
    <!--overflow-y:scroll；-->
    <!--背景图-->
    <div class="content-background"></div>
    <!--页面内容-->
    <div class="mainpage-content" align="center">
      <div class="main-carousel">
        <el-carousel
          :interval="7500"
          type="card"
          height="250px"
          trigger="click"
        >
          <el-carousel-item v-for="index in carouselItem.length" :key="index">
            <img
              class="carousel-img"
              :src="carouselItem[index - 1].url"
              :alt="carouselItem[index - 1].title"
              :title="carouselItem[index - 1].title"
            />
          </el-carousel-item>
        </el-carousel>
      </div>
      <div class="main-statistics">
        <div class="block-title">Statistics</div>
        <div class="main-statistics-content">
          <!-- <div style="width: 55px;flex: 1 1 auto;"></div> -->
          <statistics-card
            title="提交量"
            :num="histogramData.sumData.submit | stdNum"
            :predata="histogramSubmit"
          />
          <!-- <div style="width: 59px;"></div> -->
          <statistics-card
            title="通过量"
            :num="histogramData.sumData.ac | stdNum"
            :predata="histogramAC"
          />
          <!-- <div style="width: 59px;"></div> -->
          <statistics-card
            title="访问量"
            num="1,432,567"
          />
          <!-- <div class="statistics-card-block" style="width: 51px;flex: 1 1 auto;"></div> -->
        </div>
      </div>
      <div class="main-contest-list">
        <div class="block-title">Contest</div>
        <div class="main-contest-list-content">
          <contest-card
            v-for="index in contestData.length"
            :key="index"
            v-if="new Date(contestData[index - 1].end_time).getTime() >= Date.now()"
            :contest-nick="contestData[index - 1].title"
            contest-type="ACM"
            :contest-num="contestData[index - 1].contestantNum | stdNum"
            :contest-id="contestData[index - 1].id"
            style="cursor: pointer;"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import contestCard from "../components/contest-card";
import statisticsCard from "../components/main-statistics-card";
import { baidu_site_id } from "../config/env";
import {
  getCarousel,
  getDailydata,
  getContestList,
  getPvData,
} from "../api/getData";

export default {
  name: "mainpage",
  components: { statisticsCard, contestCard },
  data() {
    return {
      carouselItem: [
        // {
        //     url: ''
        // }
      ],
      histogramData: {
        sumData: {
          ac: 12453566,
          submit: 24587987,
        },
        dailyData: [
          // {
          //     time: '',
          //     ac: '',
          //     submit: ''
          // }
        ],
      },
      histogramPV: {},
      contestData: [
        // {
        //     id: 1000,
        //     title: '',
        //     contestantNum: 2244,
        //     begin_time: '',
        //     end_time: ''
        // }
      ],
    };
  },
  methods: {
    renderCarousel: async function() {
      let response = await getCarousel();
      if (response.status == 0) {
        // success
        let data = response.data;
        data.forEach((val) => {
          if (val.status == 1) {
            let res = {
              title: val.title,
              url: val.url,
            };
            // console.log(res);
            this.carouselItem.push(res);
          }
        });
      }
    },
    renderHistogram: async function() {
      let response = await getDailydata();
      if (response.status == 0) {
        let data = response.data;
        data.forEach((val, index) => {
          if (index === response.data.length - 1) {
            this.histogramData.sumData = val;
          } else {
            this.histogramData.dailyData.push(val);
          }
        });
      }
    },
    renderContest: async function() {
      let response = await getContestList();
      if (response.status == 0) {
        let data = response.data;
        data.forEach((val) => {
          let res = {
            id: val.contest_id,
            title: val.contest_name,
            contestantNum: 2244, // TODO 参加人数
            begin_time: val.begin_time,
            end_time: val.end_time,
          };
          this.contestData.push(res);
        });
      }
    },
    renderPV: async function() {
      let response = await getPvData(
        {
          site_id: baidu_site_id,
          method: "trend/time/a",
          start_date: "20191010",
          end_date: "20191011",
          metrics: "pv_count",
          max_results: 13,
          gran: "day",
        },
        {
          account_type: 1,
          password: "dtymw999124723",
          token: "你的token",
          username: "long4664030@163.com",
        }
      );
      if (response.status !== 200) return;
    },
  },
  async created() {
    this.renderCarousel();
    this.renderHistogram();
    this.renderContest();
    // this.renderPV();
  },
  filters: {
    stdNum: function(num) {
      let res = (num || 0).toString(),
        result = "";
      while (res.length > 3) {
        result = "," + res.slice(-3) + result;
        res = res.slice(0, res.length - 3);
      }
      if (res) {
        result = res + result;
      }
      return result;
    },
  },
  computed: {
    histogramAC() {
      let ans = [];
      this.histogramData.dailyData.forEach((val) => {
        let res = {
          time: val.time,
          num: val.ac,
        };
        ans.push(res);
      });
      return ans;
    },
    histogramSubmit() {
      let ans = [];
      this.histogramData.dailyData.forEach((val) => {
        let res = {
          time: val.time,
          num: val.submit,
        };
        ans.push(res);
      });
      return ans;
    },
  },
};
</script>

<style lang="scss">
/*element-ui carousel START*/

.el-carousel {
  overflow: unset !important;
  .el-carousel__indicators--outside {
    button {
      background-color: #338bb8 !important;
    }
    .is-active button {
      background-color: #338bb8 !important;
    }
  }
  &__item {
    &:nth-child(2n) {
      background-color: #99a9bf;
      border-radius: 10px;
    }
    &:nth-child(2n + 1) {
      background-color: #d3dce6;
      border-radius: 10px;
    }
  }
  &__container {
    .is-active {
      box-shadow: 0 20px 20px rgba(0, 0, 0, 0.1);
    }
  }
}

.carousel-img {
  width: 100%;
  height: 250px;
}

/*element-ui carousel END*/

.mainpage {
  position: relative;
  overflow-x: hidden;
  overflow-y: scroll;
  display: flex;
  flex-direction: column;
  width: 100%;
  height: 100%;
  &::-webkit-scrollbar-track {
    opacity: 0;
    /*background: #880000;*/
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0);
    border-radius: 10px;
  }
  &-content {
    position: relative;
  }
}

.content-background {
  z-index: -1;
  position: absolute;
  width: 100%;
  height: 100%;
  filter: blur(30px) brightness(1.15) opacity(0.5);
  /*background: white;*/
  background: url("../../assets/background/background-main.png") no-repeat
    scroll;
  background-size: 100% 422px;
  top: -32px;
}

.main-carousel {
  position: relative;
  top: 88px;
  width: 1230px;
}

.main-statistics {
  position: relative;
  top: 101px;
  margin: 0 auto;
  max-width: 1330px;
}

.main-statistics-content > * {
  margin-left: 59px;
  &:first-child {
    margin-left: 43px;
  }
}

.block-title {
  position: relative;
  font-size: 18px;
  font-weight: 700;
  left: 4%;
  width: 100%;
  text-align: left;
}

.main-statistics .main-statistics-content {
  position: relative;
  top: 14px;
  display: flex;
}

.main-contest-list {
  position: relative;
  top: 136px;
  margin: 0 auto;
  max-width: 1330px;
  .main-contest-list-content {
    margin: 0 0 0 43px;
    position: relative;
    top: 12px;
    display: flex;
    flex-wrap: wrap;
  }
}

@media (max-width: 1543px) and (min-width: 1280px) {
  .main-carousel {
    width: 996px;
    margin-left: 27px;
  }

  .main-contest-list {
    max-width: 1039px;
    &-content {
      margin-left: 33px !important;
    }
  }

  .main-statistics {
    max-width: 1039px;
  }

  .statistics-card-block {
    width: 23px !important;
  }
}

@media (max-width: 650px) {
  .main-carousel {
    width: 100%;
  }

  .main-statistics-content {
    display: flex;
    flex-direction: column;
    align-items: center;

    > * {
      // margin-left: 0;
      // margin-top: 15px;
      margin: 15px 15px 0 15px;
      
      &:first-child {
        margin: 0 15px 0 15px;
      }
    }
  }

  .main-contest-list-content {
    min-height: 150px;
  }
}
</style>
