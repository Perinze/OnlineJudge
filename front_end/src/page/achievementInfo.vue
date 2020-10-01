<template>
  <div class="container">
    <div class="leftBox">
      <span class="questionTitle">{{ this.$route.query.title }}</span>
      <div class="descList">
        <div class="descInfo" v-for="index in items.length">
          <span class="title">{{ items[index - 1].title }}</span>
          <p class="desc" align="left">{{ items[index - 1].desc }}</p>
        </div>
      </div>
      <!--        <pagination></pagination>-->

      <div class="question">
        <span class="quetitle">题目</span>
        <div class="questionList">
          <div class="questionInfo">
            <span class="quesId">W1231</span>
            <span class="quesTime">算法时间效率:10分</span>
            <span class="quesRoom">算法空间效率:10分</span>
            <button class="quesButton">改进</button>
          </div>
          <div class="questionInfo">
            <span class="quesId">W1231</span>
            <span class="quesTime">算法时间效率:10分</span>
            <span class="quesRoom">算法空间效率:10分</span>
            <button class="quesButton">改进</button>
          </div>
        </div>
      </div>
    </div>

    <div class="score">
      <span class="quetitle">得分总览</span>
      <div class="scoreInfo">
        <span>总评：10分</span>
        <span>完成时间：10分</span>
        <span>题目完成度：10分</span>
      </div>
      <div class="discussion">
        <span class="quetitle">讨论区推荐</span>
        <div class="discussionTitle">帖子标题</div>
        <div class="discussionTitle">帖子标题</div>
        <div class="discussionTitle">帖子标题</div>
      </div>
    </div>
  </div>
</template>

<script>
import pagination from "../components/pagination";
import { getAllTag } from "../api/getData";

export default {
  name: "achievementInfo",
  data() {
    return {
      items: [
        {
          title: "Dijkstra算法",
          desc:
            "Here is the description of the algorithm. Here is the description of the algorit hm.Here is the description of thedescrption of the aigorithm.Here is the descri ption of thedescrption of the aigorithm.Here is the description of thedescrption of the aigorithm.",
        },
        {
          title: "Floyd算法/Floyd-Warshall算法",
          desc:
            "Here is the description of the algorithm. Here is the description of the algorit hm.Here is the description of thedescrption of the aigorithm.Here is the descri ption of thedescrption of the aigorithm.Here is the description of thedescrption of the aigorithm.",
        },
        {
          title: "Johnson算法",
          desc:
            "Here is the description of the algorithm. Here is the description of the algorit hm.Here is the description of thedescrption of the aigorithm.Here is the descri ption of thedescrption of the aigorithm.Here is the description of thedescrption of the aigorithm.",
        },
      ],
    };
  },

  async beforeMount() {
    await this.renderAllTag();
  },

  methods: {
    renderAllTag: async function() {
      let requestData = {
        knowledge_id: this.$route.query.id,
      };
      console.log(requestData);
      let response = await getAllTag(requestData);
      console.log(response);
      if (response.status == 0) {
        let data = response.data;
        data.forEach((val, index) => {
          let res = {
            name: val.name,
            description: val.description,
          };
          this.items.push(res);
          console.log(this.items);
        });
      } else {
        // error
        if (response.status === 504) {
          this.$message({
            message: "请求超时",
            type: "error",
          });
        }
      }
    },
  },
};
</script>

<style scoped>
.container {
  background-color: #dce2ec;
}

.leftBox {
  float: left;
}

.questionTitle {
  font-size: 25px;
  color: #7d7d7d;
  padding: 30px 0 0 71px;
  display: block;
}

.descInfo {
  width: 745px;
  height: 153px;
  background: rgba(237, 239, 243, 1);
  box-shadow: 0 7px 9px 0 rgba(4, 0, 0, 0.1);
  border-radius: 15px;
  margin: 12px 21px 12px 35px;
  padding: 18px 22px 0 22px;
}

.title {
  font-size: 20px;
  font-family: PingFang SC;
  font-weight: bold;
  color: rgba(83, 83, 83, 1);
}

.desc {
  color: #626262;
  font-size: 15px;
  font-family: PingFangSC-Regular;
}

.question {
  width: 745px;
  height: 432px;
  background: rgba(251, 251, 251, 1);
  border-radius: 8px;
  margin: 12px 21px 12px 35px;
  padding: 18px 22px 0 22px;
}

.quetitle {
  font-size: 15px;
  font-family: PingFang SC;
  font-weight: bold;
  color: rgba(112, 112, 112, 1);
  padding: 20px 0 20px 0;
}

.questionList {
  margin-top: 15px;
}

.questionInfo {
  height: 40px;
  border-top: 1px solid rgba(170, 170, 170, 1);
  padding: 8px 0 3px 0;
}

.quesId {
  font-size: 13px;
  font-family: PingFang SC;
  font-weight: bold;
  color: rgba(125, 125, 125, 1);
  padding: 0 0 0 30px;
}

.quesTime {
  font-size: 13px;
  font-family: PingFang SC;
  font-weight: bold;
  color: rgba(125, 125, 125, 1);
  padding: 0 0 0 100px;
}

.quesRoom {
  font-size: 13px;
  font-family: PingFang SC;
  font-weight: bold;
  color: rgba(125, 125, 125, 1);
  padding: 0 0 0 80px;
}

.quesButton {
  width: 66px;
  height: 21px;
  background: rgba(66, 136, 206, 1);
  border-radius: 4px;
  /*float: right;*/
  margin: 0 0 0 125px;
}

.discussion {
  margin: 210px 0 0 0;
}

.score {
  width: 350px;
  height: 935px;
  background: rgba(237, 239, 243, 1);
  border-radius: 15px;
  float: right;
  margin: 83px 30px 0 0;
  padding: 20px 0 0 21px;
}

.score {
  background: rgba(237, 239, 243, 1);
  border-radius: 15px;
}

.scoreInfo {
  background: rgba(251, 251, 251, 1);
  border-radius: 8px;
  margin: 10px 8px 0 0;
  padding: 15px 0 10px 20px;
}

.scoreInfo span {
  display: block;
  padding: 5px;
}

.discussionTitle {
  width: 321px;
  height: 40px;
  background: rgba(255, 255, 255, 1);
  border-radius: 23px;
  text-align: center;
  margin: 10px 8px 0 0;
  padding: 13px 0 13px 0;
}
</style>
