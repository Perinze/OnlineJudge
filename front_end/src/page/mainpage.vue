<template>
  <div class="mainpage">
    <!--overflow-y:scroll；-->
    <!--背景图-->
    <div class="content-background" v-if="!isWap"></div>
    <!--页面内容-->
    <div class="mainpage-content" align="center">
      <div class="main-carousel">
        <el-carousel
          :interval="7500"
          :type="isWap ? '' : 'card'"
          :height="isWap ? '150px' : '250px'"
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
      <div class="main-statistics" v-show="false">
        <div class="block-title">Statistics</div>
        <div class="main-statistics-content">
          <statistics-card
            v-for="card in statistics"
            :key="card.subtitle"
            :title="card.title"
            :subtitle="card.subtitle"
            :num="card.num"
            :percent="card.percent"
          />
        </div>
      </div>
      <div class="main-contest-list">
        <div class="block-title">Contest</div>
        <div class="main-contest-list-content">
          <template v-for="index in contestData.length">
            <contest-card
              :key="index"
              v-if="new Date(contestData[index - 1].end_time.replace(/-/g, '/')).getTime() >= Date.now()"
              :contest-nick="contestData[index - 1].title"
              contest-type="ACM"
              :contest-num="contestData[index - 1].contestantNum | stdNum"
              :contest-id="contestData[index - 1].id"
              style="cursor: pointer;"
            />
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import contestCard from "../components/contest-card";
import statisticsCard from "../components/main-statistics-card";
import { baidu_site_id } from "../config/env";
import { getPvData } from "../api/getData";
import { getCarousel, getDailydata } from "../api/index";
import { getContestList } from "../api/contest";
import { judgeWap, deepEqual } from "../utils";
import { checkLogin, logout} from "../api/login";
export default {
  name: "mainpage",
  components: { statisticsCard, contestCard },
  data() {
    return {
      carouselItem: [
        {
            url: require('../../assets/media/notice1.png'),
            alt: 'test',
            title: '装你妈比'
        },
        {
            url: require('../../assets/media/notice2.png'),
            alt: '?',
            title: 'test1'
        }
      ],
      statistics: [
        {
          title: "提交量",
          subtitle: "submitted",
          num: 0,
          percent: 0
        },
        {
          title: "通过量",
          subtitle: "accepted",
          num: 0,
          percent: 0
        },
        {
          title: "访问量",
          subtitle: "page view",
          num: 0,
          percent: 0
        },
        {
          title: "题目量",
          subtitle: "problems",
          num: 0,
          percent: 0
        }
      ],
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
        const data = response.data.filter(x => x.status);
        if (!deepEqual(this.carouselItem, data)) {
          this.carouselItem = data;
          localStorage.setItem('carousel', JSON.stringify(data));
        }
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
          if(val.begin_time[19] == 'Z') val.begin_time = val.begin_time.substr(0,19);
            val.begin_time = val.begin_time.replace("T", " ");
          if(val.end_time[19] == 'Z') val.end_time = val.end_time.substr(0,19);
            val.end_time = val.end_time.replace("T", " ");
          let res = {
            id: val.contest_id,
            title: val.contest_name,
            contestantNum: 12138, // TODO 参加人数
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
    loginCheck: async function (){
      let getFlag = localStorage.getItem("Flag");
      if (getFlag !== "isLogin"){
        let resp = await checkLogin();
          if(resp.status == 0){
            console.log("!");
            console.log(resp);
            await logout();
        }
      }
    },
    getCarouselCache() {
      const str = localStorage.getItem('carousel');
      try {
        const data = JSON.parse(str);
        this.carouselItem = data.filter(x => x.status);
      } catch (e) {
        localStorage.removeItem('carousel');
      }
    }
  },
  async created() {
    this.getCarouselCache();
    this.renderCarousel();
    // this.renderHistogram();
    this.renderContest();
    // this.renderPV();
  },
  async mounted(){
    this.loginCheck();
    /*let getFlag = localStorage.getItem("Flag");
    if (getFlag !== "isLogin"){
      let resp = checkLogin();
        if(resp.status == 0){
          logout();
      }
    }*/
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
    isWap() {
      return judgeWap();
    },
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

@media screen and (max-width: 650px) {
  .el-carousel {
    overflow: hidden !important;
  }

  .carousel-img {
    width: 100%;
    height: 150px;
  }
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
  margin-left: 25px;
  &:first-child {
    margin-left: 0;
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
  flex-direction: row;
  justify-content: space-between;
  padding-left: 43px;
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
    height: 150px;
    padding: 0 16px;
  }

  .main-statistics {
    width: unset;

    .main-statistics-content {
      overflow-x: scroll;
      width: unset;
      height: 120px;
      padding: 0 15px;
      
      &::-webkit-scrollbar {
        width: 0 !important
      }
      -ms-overflow-style: none;
      overflow: -moz-scrollbars-none;

      > * {
        margin: 0 calc(15px / 2);
        width: 100%;

        &:first-child {
          margin-left: 0;
        }
      }
    }
  }

  .main-contest-list {
    top: 86px; 

    .main-contest-list-content {
      display: flex;
      flex-direction: column;
      min-height: 150px;
      margin: 0;
      padding: 0 12px;

      > div {
        margin: 5px 0;
        box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.08);

        &:first-child {
          margin-top: 0;
        }
      }
    }
  }

}
</style>
