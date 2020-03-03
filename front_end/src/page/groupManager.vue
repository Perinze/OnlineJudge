<template>
  <div class="container">
    <div class="header">
      <h1 class="title group-name">拖延与压榨</h1>
      <div class="anchor-links">
        <div
          :href="item.href"
          v-for="(item, index) in anchors"
          :class="['anchor-links-item', item.isActive ? 'anchor-links-item-active' : '']"
          @click="toggleAnchor(index)"
          :key="item.label"
        >{{item.label}}</div>
      </div>
    </div>
    <div class="table">
      <div class="table-header">
        <h2 class="table-title">小组成员</h2>
        <div class="search">
          <svg
            t="1552933355466"
            class="icon"
            style
            viewBox="0 0 1024 1024"
            version="1.1"
            xmlns="http://www.w3.org/2000/svg"
            p-id="16778"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            width="16"
            height="16"
          >
            <path
              d="M976.724714 897.502035c8.738122 10.239986 13.107183 21.572238 13.107183 33.996755a48.469269 48.469269 0 0 1-14.745581 35.566886 48.469269 48.469269 0 0 1-35.703419 14.813847 53.247929 53.247929 0 0 1-16.930111-2.730663 45.533806 45.533806 0 0 1-20.479972-13.789848l0.136533 1.228798-270.813506-272.793236a368.844308 368.844308 0 0 1-242.824209 67.925242 266.922311 266.922311 0 0 1-46.421272-8.055456c-45.533806-3.071996-105.608393-28.808495-155.10166-67.447376-30.037293-17.612777-70.997239-61.030319-101.717197-115.097447a350.2758 350.2758 0 0 1-47.103937-144.315541c2.79893 32.49489-3.071996-4.164261-3.481596-42.120477 0.273066 12.970649 0 4.915193 0-3.208529 0-22.801036 2.047997-45.124207 6.007459-66.832978 9.557321-59.664987 33.860222-114.619581 69.085774-160.836052 17.476243-32.767956 73.386569-82.807356 140.014747-113.322515-34.747687 14.199448 1.297065-5.461326 41.096479-19.387708a361.812851 361.812851 0 0 1 122.19717-20.821305A371.233638 371.233638 0 0 1 587.536966 43.009308a368.502975 368.502975 0 0 1 149.981667 143.086743c-12.56105-28.398895 13.516782 13.926381 31.402625 62.873516 17.954109 48.947135 25.873032 98.576935 23.620235 149.025934-2.867196 83.967888-31.743958 159.538987-86.630284 226.781565l271.90577 272.724969h-1.023998z m-241.254078-500.598799a306.380391 306.380391 0 0 0-22.664503-133.529422A309.930253 309.930253 0 0 0 631.091042 143.63424c27.989296 26.828764 9.147721 6.621858-12.356251-11.332251A322.55957 322.55957 0 0 0 475.784582 63.489281c34.065021 5.802659-12.014917-5.119993-60.620719-5.119993-13.107183 0-25.941299 0.819199-38.638882 2.321063a38.638882 38.638882 0 0 0-9.147721 1.092265L361.574601 62.806615a311.022519 311.022519 0 0 0-153.599795 70.314573c-31.812224 19.797307-73.727902 74.069235-95.436673 137.693683-2.730663-9.011188-17.54451 40.618613-20.13864 95.436673a309.930253 309.930253 0 0 0 30.173827 152.234463 308.974521 308.974521 0 0 0 128.409428 141.380079c-0.2048 7.37279 57.139124 33.928488 120.21744 41.983944 2.047997 4.027728 49.151934 6.621858 96.733738-1.433599a318.395309 318.395309 0 0 0 110.250519-41.574344c11.400518-2.18453 52.83833-33.860222 85.33322-73.181769-12.629316 20.957839 23.210636-23.415435 46.421271-74.751901-33.109289 58.914055-19.387707 37.956216-8.465055 15.291713 21.026105-40.27728 33.587155-87.995616 34.269821-138.512882l-0.273066 9.284255z"
              p-id="16779"
              fill="#B7B8BC"
            />
          </svg>
          <input type="text" class="nick-input" placeholder="输入成员昵称查找" />
        </div>
      </div>
      <el-table
        :data="members"
        style="width: 100%;"
        :header-cell-style="{fontSize: 15 + 'px', fontWeight: 'bold', color: 'rgba(124,127,132,1)'}"
        :cell-style="{fontSize: 15 + 'px', fontWeight: 'bold', color: 'rgba(124,127,132,1)'}"
      >
        <el-table-column type="expand">
          <template slot-scope="props">
            <div class="table-expand-item">
              <label class="table-expand-item-label">个人描述:</label>
              <span class="table-expand-item-text">{{props.row.desc}}</span>
            </div>
          </template>
        </el-table-column>
        <el-table-column label="昵称" prop="nick"></el-table-column>
        <el-table-column label="AC数" prop="acCnt"></el-table-column>
        <el-table-column label="WA数" prop="waCnt"></el-table-column>
        <el-table-column align="right" width="240">
          <template slot-scope="scope">
            <div class="operations">
              <button class="btn-setAdmin">{{scope.row.isAdmin ? '取消管理员身份' : '设置为管理员'}}</button>
              <button class="btn-clear">踢出</button>
            </div>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <h1 class="title">题库管理</h1>
    <div class="table">
      <el-table
        :data="problems"
        style="width: 100%;"
        :header-cell-style="{fontSize: 20 + 'px', fontWeight: 'bold', color: 'rgba(124,127,132,1)'}"
        :cell-style="{fontSize: 15 + 'px', fontWeight: 'bold', color: 'rgba(124,127,132,1)'}"
      >
        <el-table-column label="题号" prop="problemId"></el-table-column>
        <el-table-column label="题目" prop="problemCon"></el-table-column>
        <el-table-column align="right" width="240">
          <template slot="header" slot-scope="scope">
            <div class="operations">
              <button class="btn-add-problem">新增</button>
              <button class="btn-remove-choose" @click="removeChoose">移出已选</button>
            </div>
          </template>
          <template slot-scope="scope">
            <div
              :class="['radio', scope.row.isChoose ? 'radio-choose' : '']"
              @click="chooseProblem(scope.$index)"
            >
              <img
                src="../../assets/media/choose.png"
                class="choose-icon"
                v-show="scope.row.isChoose"
              />
            </div>
          </template>
        </el-table-column>
      </el-table>
      <pagination :total="70" :pageSize="10" :pageCount="7"></pagination>
    </div>
    <button class="btn-compelete">完成</button>
    <h1 class="title">比赛发起</h1>
    <h2 class="subtitle">题目选择</h2>
    <div class="table">
      <el-table
        :data="contests"
        style="width: 100%;"
        :header-cell-style="{fontSize: 20 + 'px', fontWeight: 'bold', color: 'rgba(124,127,132,1)'}"
        :cell-style="{fontSize: 15 + 'px', fontWeight: 'bold', color: 'rgba(124,127,132,1)'}"
      >
        <el-table-column label="题号" prop="problemId"></el-table-column>
        <el-table-column label="题目" prop="problemCon"></el-table-column>
        <el-table-column align="right" width="240">
          <!-- <template slot="header" slot-scope="scope">
            <button class="btn-remove-choose" @click="removeChoose">移出已选</button>
          </template>-->
          <template slot-scope="scope">
            <div
              :class="['radio', scope.row.isChoose ? 'radio-choose' : '']"
              @click="chooseContest(scope.$index)"
            >
              <img
                src="../../assets/media/choose.png"
                class="choose-icon"
                v-show="scope.row.isChoose"
              />
            </div>
          </template>
        </el-table-column>
      </el-table>
      <pagination :total="70" :pageSize="10" :pageCount="7"></pagination>
      <div class="contest-time">
        <div class="contest-time-block">
          <h3 class="time-title">报名时间开始</h3>
          <el-date-picker v-model="enrollStart" type="datetime" placeholder="选择日期时间"></el-date-picker>
        </div>
        <div class="contest-time-block">
          <h3 class="time-title">报名时间结束</h3>
          <el-date-picker v-model="enrollEnd" type="datetime" placeholder="选择日期时间"></el-date-picker>
        </div>
        <div class="contest-time-block">
          <h3 class="time-title">比赛时间开始</h3>
          <el-date-picker v-model="contestStart" type="datetime" placeholder="选择日期时间"></el-date-picker>
        </div>
        <div class="contest-time-block">
          <h3 class="time-title">比赛时间结束</h3>
          <el-date-picker v-model="contestEnd" type="datetime" placeholder="选择日期时间"></el-date-picker>
        </div>
      </div>
    </div>
    <button class="btn-compelete">完成</button>
  </div>
</template>

<script>
import pagination from "../components/pagination";

export default {
  name: "groupManager",
  components: { pagination },
  data() {
    return {
      anchors: [
        { href: "#members", label: "小组成员", isActive: true },
        { href: "#problems", label: "题库管理", isActive: false },
        { href: "#contests", label: "比赛发起", isActive: false }
      ],
      members: [
        {
          id: 1,
          isAdmin: false,
          nick: "codeplay",
          acCnt: 12,
          waCnt: 100,
          desc: "hello world"
        },
        {
          id: 2,
          isAdmin: true,
          nick: "maydusa",
          acCnt: 14,
          waCnt: 90,
          desc: "hello world"
        },
        {
          id: 3,
          isAdmin: false,
          nick: "kobe",
          acCnt: 122,
          waCnt: 0,
          desc: "hello world"
        }
      ],
      problems: [
        {
          problemId: 2,
          problemCon: "This is a problem.",
          isChoose: false
        },
        {
          problemId: 5,
          problemCon: "This is a problem.",
          isChoose: false
        }
      ],
      contests: [
        {
          problemId: 4,
          problemCon: "This is a problem.",
          isChoose: false
        },
        {
          problemId: 10,
          problemCon: "This is a problem.",
          isChoose: false
        }
      ],
      enrollStart: "",
      enrollEnd: "",
      contestStart: "",
      contestEnd: ""
    };
  },
  mounted() {
    document
      .getElementsByClassName("combox")[0]
      .addEventListener("scroll", this.debounce(this.updateAnchorActive, 500));
  },
  methods: {
    debounce: function(fn, delay) {
      let timer = null;
      return function() {
        let _this = this;
        clearTimeout(timer); // 每次调用debounce函数都会将前一次的timer清空，确保只执行一次
        let args = arguments;
        timer = setTimeout(() => {
          fn.apply(_this, args);
        }, delay);
      };
    },
    toggleAnchor: function(index) {
      // 39是第一个h1(class为title)标签也就是团队名的offsetTop
      for (let i = 0; i < this.anchors.length; i++) {
        if (i == index) {
          this.$set(this.anchors[i], "isActive", true);
          document.getElementsByClassName("combox")[0].scrollTop =
            document.querySelectorAll(".layout-content .title")[index]
              .offsetTop - 39;
        } else {
          this.$set(this.anchors[i], "isActive", false);
        }
      }
    },
    updateAnchorActive: function() {
      // 39是第一个h1(class为title)标签也就是团队名的offsetTop
      let titles = document.querySelectorAll(".layout-content .title"),
        offsetTopArr = [
          titles[0].offsetTop - 39,
          titles[1].offsetTop - 39,
          titles[2].offsetTop - 39
        ],
        scrollTop = document.getElementsByClassName("combox")[0].scrollTop,
        index;
      if (scrollTop < offsetTopArr[1]) {
        index = 0;
      } else if (scrollTop < offsetTopArr[2]) {
        index = 1;
      } else {
        index = 2;
      }
      for (let i = 0; i < this.anchors.length; i++) {
        if (i == index) {
          this.$set(this.anchors[i], "isActive", true);
        } else {
          this.$set(this.anchors[i], "isActive", false);
        }
      }
    },
    chooseProblem: function(index) {
      this.problems[index].isChoose = !this.problems[index].isChoose;
    },
    chooseContest: function(index) {
      this.contests[index].isChoose = !this.contests[index].isChoose;
    },
    removeChoose: function() {
      for (let i = 0; i < this.problems.length; i++) {
        if (this.problems[i].isChoose) {
          this.problems[i].isChoose = false;
        }
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.container {
  padding: 39px 97px;
}
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 40px;
}
.title {
  margin-top: 51px;
  margin-bottom: 53px;
  font-size: 23px;
  font-weight: bold;
  color: rgba(125, 125, 125, 1);
}
.title:nth-of-type(2) {
  margin-top: 90px;
}
.btn-compelete {
  width: 111px;
  height: 26px;
  background: rgba(66, 136, 206, 1);
  border-radius: 12px;
  margin-top: 27px;
  font-size: 13px;
  font-weight: bold;
  color: rgba(255, 255, 255, 1);
  float: right;
}
.group-name {
  margin: 0;
}
.anchor-links {
  display: flex;
  align-items: center;
}
.anchor-links-item {
  font-size: 17px;
  font-weight: 400;
  color: rgba(191, 191, 191, 1);
  margin: 0 27px;
  cursor: pointer;
}
.anchor-links-item:last-of-type {
  margin-right: 0;
}
.anchor-links-item-active {
  color: rgba(66, 136, 206, 1);
}
.table {
  width: 100%;
  padding: 10px 20px;
  background: #fff;
  border-radius: 8px;
}
.table-header {
  width: 100%;
  height: 60px;
  padding: 0 10px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.table-title {
  margin: 0;
  font-size: 20px;
  font-weight: bold;
  color: rgba(124, 127, 132, 1);
}
.table-expand-item {
  padding-left: 10px;
  font-size: 14px;
  font-weight: bold;
  color: rgba(124, 127, 132, 1);
}
.table-expand-item-label {
  display: inline-block;
  margin-right: 10px;
}
.table-expand .el-form-item {
  margin-right: 0;
  margin-bottom: 0;
  width: 50%;
}
.operations {
  display: flex;
  font-size: 13px;
  font-weight: 400;
  color: rgba(255, 255, 255, 1);
}
.search {
  width: 320px;
  height: 35px;
  background: rgba(238, 238, 238, 1);
  border-radius: 18px;
  display: flex;
  align-items: center;
  padding-left: 26px;
  padding-right: 26px;
}
.nick-input {
  flex-grow: 1;
  margin-left: 10px;
  background: rgba(238, 238, 238, 1);
  font-size: 13px;
  font-weight: 400;
  color: rgba(183, 184, 188, 1);
}
.btn-setAdmin {
  width: 108px;
  height: 26px;
  background: rgba(66, 136, 206, 1);
  border-radius: 3px;
  margin-right: 18px;
}
.btn-clear {
  width: 80px;
  height: 26px;
  background: rgba(149, 149, 149, 1);
  border-radius: 3px;
}
.radio {
  width: 21px;
  height: 21px;
  border-radius: 50%;
  box-sizing: border-box;
  border: 1px solid rgba(66, 136, 206, 1);
  display: flex;
  justify-content: center;
  align-items: center;
  float: right;
  cursor: pointer;
}
.radio-choose {
  background: rgba(66, 136, 206, 1);
}
.choose-icon {
  width: 9.5px;
  height: 7px;
}
.btn-add-problem,
.btn-remove-choose {
  width: 98px;
  height: 35px;
  background: rgba(210, 210, 210, 1);
  border-radius: 5px;
  font-size: 15px;
  font-weight: 400;
  color: rgba(255, 255, 255, 1);
  line-height: 1;
}
.btn-add-problem {
  background: rgba(210, 210, 210, 1);
  margin-right: 36px;
}
.btn-remove-choose {
  background: rgba(66, 136, 206, 1);
}
.title:nth-of-type(2) {
  display: inline-block;
}
.subtitle {
  font-size: 20px;
  font-weight: 400;
  color: rgba(160, 160, 160, 1);
  display: inline-block;
  margin-left: 22px;
}
.contest-time {
  padding: 0 19px;
}
.contest-time-block {
  display: flex;
  align-items: center;
  width: 50%;
}
.time-title {
  font-size: 17px;
  font-weight: 400;
  color: rgba(125, 125, 125, 1);
  margin-right: 10px;
}
</style>