<template>
  <div class="container">
    <input type="text" class="title-input" placeholder="在此输入标题..." />
    <div id="editor"></div>
    <div class="table">
      <el-table
        :data="tableProblems"
        style="width: 100%;"
        :header-cell-style="{fontSize: 20 + 'px', fontWeight: 'bold', color: 'rgba(124,127,132,1)'}"
        :cell-style="{fontSize: 15 + 'px', fontWeight: 'bold', color: 'rgba(124,127,132,1)'}"
      >
        <el-table-column label="题号" prop="problem_id"></el-table-column>
        <el-table-column label="题目" prop="title"></el-table-column>
        <el-table-column align="right" width="240">
          <template slot="header" slot-scope="scope">
            <button class="btn-remove-choose" @click="removeChoose">移出已选</button>
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
      <pagination :total="count" :pageSize="10" :pageCount="6" :fetchData="fetchProblems"></pagination>
    </div>
    <button class="btn-compelete" @click="publish">发布</button>
  </div>
</template>

<script>
import { loadScript, loadCss } from "../utils";
import { getProblemList, addDiscuss } from "../api/getData";
import pagination from "../components/pagination";

export default {
  name: "addDiscussion",
  components: { pagination },
  data() {
    return {
      problems: {},
      tableProblems: [],
      count: 0
    };
  },
  mounted() {
    loadScript("./jquery.min.js")
      .then(res => {
        return loadScript("./editormd.min.js");
      })
      .then(res => {
        return loadCss("./editormd.min.css");
      })
      .then(res => {
        let editor = editormd("editor", {
          width: "100%",
          path: "./lib/",
          placeholder: "在此输入内容...",
          fontSize: "14px",
          emoji: true,
          saveHTMLToTextarea: true
        });
      });

    // getProblemList().then(res => {
    //   this.problems["0"] = res.data.data;
    //   this.tableProblems = res.data.data;
    // });
    // fetch("./data.json")
    //   .then(res => {
    //     return res.json();
    //   })
    //   .then(resJson => {
    //     window.console.log(resJson);
    //     this.count = resJson.count;
    //     this.problems = resJson.data;
    //     this.tableProblems = resJson.data;
    //   });
    this.fetchProblems(1);
  },
  methods: {
    chooseProblem: function(index) {
      this.problems[index].isChoose = !this.problems[index].isChoose;
    },
    removeChoose: function() {
      for (let i = 0; i < this.problems.length; i++) {
        if (this.problems[i].isChoose) {
          this.problems[i].isChoose = false;
        }
      }
    },
    fetchProblems: function(index) {
      window.console.log(index);
      if (this.problems[index]) return;
      fetch("./data.json")
        .then(res => {
          return res.json();
        })
        .then(resJson => {
          this.count = resJson.count;
          this.problems[index] = resJson.data;
          this.tableProblems = resJson.data;
          window.console.log(this.problems);
        });
    },
    publish: function() {
      addDiscuss({
        problem_id: 1020,
        content: "<p>This is a discussion about problem 1000</p>",
        title: "A discussion"
      }).then(res => {
        window.console.log(res);
      });
    }
  }
};
</script>

<style lang="scss" scoped>
.container {
  padding: 62px 85px;
}
.title-input {
  font-size: 28px;
  font-weight: bold;
  color: rgba(112, 112, 112, 1);
  background: #f0f0f7;
  margin-bottom: 20px;
}
.table {
  width: 100%;
  padding: 10px 20px;
  background: #fff;
  border-radius: 8px;
  margin-bottom: 20px;
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
.btn-compelete {
  width: 101px;
  height: 29px;
  background: rgba(66, 136, 206, 1);
  border-radius: 15px;
  font-size: 15px;
  font-weight: 400;
  color: rgba(255, 255, 255, 1);
  float: right;
}
</style>