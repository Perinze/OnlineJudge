<template>
  <div class="container">
    <div class="header">
      <h1 class="title">创建题库</h1>
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
        <input type="text" class="problem-input" placeholder="搜索题目关键字" />
      </div>
    </div>
    <div class="table">
      <el-table
        :data="tableData"
        style="width: 100%;"
        :header-cell-style="{
          fontSize: 20 + 'px',
          fontWeight: 'bold',
          color: 'rgba(124,127,132,1)',
        }"
        :cell-style="{
          fontSize: 15 + 'px',
          fontWeight: 'bold',
          color: 'rgba(124,127,132,1)',
        }"
      >
        <el-table-column label="题号" prop="problemId"></el-table-column>
        <el-table-column label="题目" prop="problemCon"></el-table-column>
        <el-table-column align="right">
          <template slot="header" slot-scope="scope">
            <button class="btn-choose-all" @click="chooseAll">本页全选</button>
          </template>
          <template slot-scope="scope">
            <div
              :class="['radio', scope.row.isChoose ? 'radio-choose' : '']"
              @click="choose(scope.$index)"
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
  </div>
</template>
<script>
import pagination from "../components/pagination";

export default {
  name: "addProblem",
  components: { pagination },
  data() {
    return {
      tableData: [
        {
          problemId: "2016-05-02",
          problemCon: "王小虎",
          isChoose: false,
        },
        {
          problemId: "2016-05-04",
          problemCon: "王小虎",
          isChoose: false,
        },
        {
          problemId: "2016-05-01",
          problemCon: "王小虎",
          isChoose: false,
        },
        {
          problemId: "2016-05-03",
          problemCon: "王小虎",
          isChoose: false,
        },
      ],
    };
  },
  methods: {
    choose: function(index) {
      this.tableData[index].isChoose = !this.tableData[index].isChoose;
    },
    chooseAll: function() {
      for (let i = 0; i < this.tableData.length; i++) {
        this.tableData[i].isChoose = true;
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.container {
  padding: 61px 97px;
}
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
}
.title {
  margin: 0;
  font-size: 23px;
  font-weight: bold;
  color: rgba(125, 125, 125, 1);
}
.search {
  width: 321px;
  height: 35px;
  background: rgba(251, 251, 251, 1);
  box-shadow: 0px 10px 20px 0px rgba(4, 0, 0, 0.06);
  border-radius: 18px;
  display: flex;
  align-items: center;
  padding-left: 26px;
  padding-right: 26px;
}
.problem-input {
  flex-grow: 1;
  margin-left: 10px;
  background: rgba(251, 251, 251, 1);
  font-size: 13px;
  font-weight: 400;
  color: rgba(183, 184, 188, 1);
}
.table {
  width: 100%;
  padding: 10px 20px;
  background: #fff;
  border-radius: 8px;
}
.btn-choose-all {
  width: 122px;
  height: 29px;
  background: rgba(66, 136, 206, 1);
  border-radius: 12px;
  font-size: 14px;
  font-weight: 400;
  color: rgba(255, 255, 255, 1);
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
.empty {
  height: 23px;
}
.btn-compelete {
  width: 111px;
  height: 26px;
  background: rgba(66, 136, 206, 1);
  border-radius: 12px;
  font-size: 13px;
  font-weight: bold;
  color: rgba(255, 255, 255, 1);
  margin-top: 33px;
  float: right;
}
</style>
