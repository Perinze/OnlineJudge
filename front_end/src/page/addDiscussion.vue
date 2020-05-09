<template>
  <div class="container">
    <input type="text" class="title-input" placeholder="在此输入标题..." v-model="title" />
    <div id="editor"></div>
    <div class="contest-table" v-if="this.$route.params.type == 1">
      <el-table
              :data="contests"
              style="width: 100%;"
              :header-cell-style="{fontSize: 20 + 'px', fontWeight: 'bold', color: 'rgba(124,127,132,1)'}"
              :cell-style="{fontSize: 15 + 'px', fontWeight: 'bold', color: 'rgba(124,127,132,1)'}"
      >
        <el-table-column label="比赛ID" prop="contest_id"></el-table-column>
        <el-table-column label="比赛名" prop="contest_name"></el-table-column>
        <el-table-column align="right" width="240">
          <template slot="header" slot-scope="scope">
            <button class="btn-remove-choose" @click="removeContestChoose">移出已选</button>
          </template>
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
    </div>
    <div class="problem-table">
      <el-table
              :data="problems"
              style="width: 100%;"
              :header-cell-style="{fontSize: 20 + 'px', fontWeight: 'bold', color: 'rgba(124,127,132,1)'}"
              :cell-style="{fontSize: 15 + 'px', fontWeight: 'bold', color: 'rgba(124,127,132,1)'}"
      >
        <el-table-column label="题目ID" prop="problem_id"></el-table-column>
        <el-table-column label="题目" prop="title"></el-table-column>
        <el-table-column align="right" width="240">
          <template slot="header" slot-scope="scope">
            <button class="btn-remove-choose" @click="removeProblemChoose">移出已选</button>
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
      <pagination :total="problemsCount" :pageSize="PAGESIZE" :pageCount="PAGECOUNT" :fetchData="fetchProblems" v-if="this.$route.params.type == 0"></pagination>
    </div>
    <button class="btn-compelete" @click="publish">发布</button>
  </div>
</template>

<script>
  import { loadScript, loadCss } from "../utils";
  import { getProblemList, addDiscuss, getContestList, getContest } from "../api/getData";
  import pagination from "../components/pagination";
  import { PAGESIZE, PAGECOUNT } from "../config/index";

  export default {
    name: "addDiscussion",
    components: { pagination },
    data() {
      return {
        PAGESIZE,
        PAGECOUNT,
        title: "",
        problems: [],
        problemsCount: 0,
        problem_id: 0,
        contests: [],
        contest_id: 0,
        editor: null
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
                this.editor = editormd("editor", {
                  width: "100%",
                  path: "./lib/",
                  placeholder: "在此输入内容...",
                  fontSize: "14px",
                  emoji: true,
                  saveHTMLToTextarea: true
                });
              });
      if (this.$route.params.type == 0) {
        this.fetchProblems(1);
      } else {
        this.fetchContests();
      }
    },
    methods: {
      chooseProblem: function(index) {
        const tempProblems = this.problems;
        for (let i = 0; i < tempProblems.length; i++) {
          if (i == index) {
            tempProblems[i].isChoose = true;
            this.problem_id = tempProblems[i].problem_id;
          } else {
            tempProblems[i].isChoose = false;
          }
        }
        this.problems = tempProblems;
      },
      removeProblemChoose: function() {
        for (let i = 0; i < this.problems.length; i++) {
          if (this.problems[i].isChoose) {
            this.problems[i].isChoose = false;
          }
        }
        this.problem_id = 0;
      },
      fetchProblems: function(index) {
        if (this.$route.params.type == 0) {
          getProblemList(index - 1).then(res => {
            if (res.status == 0) {
              const tempProblems = res.data.data;
              tempProblems.map(item => {
                item.isChoose = false;
                return item;
              });
              this.problems = tempProblems;
              this.problemsCount = res.data.count;
            } else {
              this.$message({
                message: res.message,
                type: 'error'
              })
            }
          })
        }
      },
      chooseContest: function(index) {
        const tempContests = this.contests;
        for (let i = 0; i < tempContests.length; i++) {
          if (i == index) {
            tempContests[i].isChoose = true;
            this.contest_id = tempContests[i].contest_id;
            getContest({contest_id: tempContests[i].contest_id}).then(res => {
              if (res.status == 0) {
                const tempProblems = [];
                res.data.problems.map(item => {
                  tempProblems.push({
                    problem_id: item,
                    isChoose: false
                  })
                })
                this.problems = tempProblems;
                this.problem_id = 0;
              } else {
                this.$message({
                  message: res.message,
                  type: 'error'
                })
              }
            })
          } else {
            tempContests[i].isChoose = false;
          }
        }
        this.contests = tempContests;
      },
      removeContestChoose: function() {
        for (let i = 0; i < this.contests.length; i++) {
          if (this.contests[i].isChoose) {
            this.contests[i].isChoose = false;
          }
        }
        this.contest_id = 0;
      },
      fetchContests: function() {
        getContestList().then(res => {
          if (res.status == 0) {
            const tempContests = res.data;
            tempContests.map(item => {
              item.isChoose = false;
              return item;
            })
            this.contests = tempContests;
          } else {
            this.$message({
              message: res.message,
              type: 'error'
            })
          }
        })
      },
      publish: function() {
        if (this.$route.params.type == 0) {
          addDiscuss({
            problem_id: this.problem_id,
            content: this.editor.getHTML(),
            title: this.title
          }).then(res => {
            this.$message({
              message: res.message,
              type: res.status == 0 ? 'success' : 'error'
            })
          });
        } else {
          addDiscuss({
            problem_id: this.problem_id,
            contest_id: this.contest_id,
            content: this.editor.getHTML(),
            title: this.title
          }).then(res => {
            this.$message({
              message: res.message,
              type: res.status == 0 ? 'success' : 'error'
            })
          });
        }
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
  .problem-table,
  .contest-table {
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
