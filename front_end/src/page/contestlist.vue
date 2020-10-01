<template>
  <div class="contestlist">
    <div class="separator"><i>正在进行</i></div>
    <div
      class="contest-card"
      v-for="index in items.length"
      :key="'contest-card-' + index"
      v-if="
        new Date(items[index - 1].begin_time).getTime() <=
          new Date().getTime() &&
          new Date().getTime() < new Date(items[index - 1].end_time).getTime()
      "
    >
      <div class="contest-content" @click="goto(items[index - 1].id)">
        <div class="content-words">
          <span class="contest-title">{{ items[index - 1].title }}</span>
          <span class="contest-sub-title">{{
            items[index - 1].begin_time + " — " + items[index - 1].end_time
          }}</span>
        </div>
      </div>
      <div class="function-btn-group">
        <!--disabled-->
        <button
          class="join"
          :class="[
            items[index - 1].status === 1 &&
            new Date(items[index - 1].end_time).getTime() >
              new Date().getTime()
              ? 'can-join'
              : 'cant-join',
          ]"
          @click="doJoinContest(index - 1)"
          v-show="!items[index - 1].hasJoin"
        >
          {{
            items[index - 1].status === 1 &&
            new Date(items[index - 1].end_time).getTime() >
              new Date().getTime()
              ? "点我报名"
              : "不可报名"
          }}
        </button>
        <button
          class="join"
          :class="[
            items[index - 1].status === 1 &&
            new Date(items[index - 1].end_time).getTime() >
              new Date().getTime()
              ? 'has-join'
              : 'cant-join',
          ]"
          v-show="items[index - 1].hasJoin"
        >
          已经报名
        </button>
      </div>
    </div>
    <div class="separator"><i>即将到来</i></div>
    <div
      class="contest-card"
      v-for="index in items.length"
      :key="'contest-card-' + index"
      v-if="
        new Date().getTime() <= new Date(items[index - 1].begin_time).getTime()
      "
    >
      <div class="contest-content" @click="goto(items[index - 1].id)">
        <div class="content-words">
          <span class="contest-title">{{ items[index - 1].title }}</span>
          <span class="contest-sub-title">{{
            items[index - 1].begin_time + " — " + items[index - 1].end_time
          }}</span>
        </div>
      </div>
      <div class="function-btn-group">
        <!--disabled-->
        <button
          class="join"
          :class="[
            items[index - 1].status === 1 &&
            new Date(items[index - 1].end_time).getTime() >
              new Date().getTime()
              ? 'can-join'
              : 'cant-join',
          ]"
          @click="doJoinContest(index - 1)"
          v-show="!items[index - 1].hasJoin"
        >
          {{
            items[index - 1].status === 1 &&
            new Date(items[index - 1].end_time).getTime() >
              new Date().getTime()
              ? "点我报名"
              : "不可报名"
          }}
        </button>
        <button
          class="join"
          :class="[
            items[index - 1].status === 1 &&
            new Date(items[index - 1].end_time).getTime() >
              new Date().getTime()
              ? 'has-join'
              : 'cant-join',
          ]"
          v-show="items[index - 1].hasJoin"
        >
          已经报名
        </button>
      </div>
    </div>
    <div class="separator"><i>已经结束</i></div>
    <div
      class="contest-card"
      v-for="index in items.length"
      :key="'contest-card-' + index"
      v-if="
        new Date().getTime() >= new Date(items[index - 1].end_time).getTime()
      "
    >
      <div class="contest-content" @click="goto(items[index - 1].id)">
        <div class="content-words">
          <span class="contest-title">{{ items[index - 1].title }}</span>
          <span class="contest-sub-title">{{
            items[index - 1].begin_time + " — " + items[index - 1].end_time
          }}</span>
        </div>
      </div>
      <div class="function-btn-group">
        <!--disabled-->
        <button
          class="join"
          :class="[
            items[index - 1].status === 1 &&
            new Date(items[index - 1].end_time).getTime() >
              new Date().getTime()
              ? 'can-join'
              : 'cant-join',
          ]"
          @click="doJoinContest(index - 1)"
          v-show="!items[index - 1].hasJoin"
        >
          {{
            items[index - 1].status === 1 &&
            new Date(items[index - 1].end_time).getTime() >
              new Date().getTime()
              ? "点我报名"
              : "不可报名"
          }}
        </button>
        <button
          class="join"
          :class="[
            items[index - 1].status === 1 &&
            new Date(items[index - 1].end_time).getTime() >
              new Date().getTime()
              ? 'has-join'
              : 'cant-join',
          ]"
          v-show="items[index - 1].hasJoin"
        >
          已经报名
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { getContestList, getUserContest, joinContest } from "../api/getData";

export default {
  name: "contestlist",
  data() {
    return {
      items: [
        // {
        //     id: '1000',
        //     title: '2019年武汉理工大学第二届新生赛',
        //     begin_time: '2019.11.16',
        //     end_time: '2019.11.16',
        //     hasJoin: false,
        //     status: 1
        // },
      ],
    };
  },
  methods: {
    renderList: async function() {
      this.$loading.open();
      let response = await getContestList();
      if (response.status === 0) {
        let data = response.data;
        data.forEach((val) => {
          let res = {
            id: val.contest_id.toString(),
            title: val.contest_name,
            begin_time: val.begin_time,
            end_time: val.end_time,
            hasJoin: false,
            status: parseInt(val.status),
          };
          this.items.push(res);
        });
      } else {
        if (response.status === 504) {
          this.$message({
            content: "请求超时",
            type: "error",
          });
        }
      }
      this.$loading.hide();
    },
    getUserContestList: async function() {
      let response = await getUserContest();
      if (response.status == 0) {
        response.data.forEach((val) => {
          let itemsIndex = this.items
            .map((x) => parseInt(x.id))
            .indexOf(parseInt(val.contest_id));
          if (itemsIndex !== -1) this.items[itemsIndex].hasJoin = true;
        });
      } else {
        if (response.message == "无比赛数据") {
          // pass
        }
      }
    },
    doJoinContest: async function(index) {
      if (
        !(this.items[index].status === 1 &&
          new Date(this.items[index].end_time).getTime() > Date.now())
      ) {
        return;
      }
      this.$loading.open();
      let response = await joinContest({
        contest_id: this.items[index].id,
      });
      if (response.status == 0) {
        this.items[index].hasJoin = true;
        this.$message({
          message: "参加比赛成功, 请记得按时参赛",
          type: "success",
        });
      } else {
        this.$message({
          message: "参加比赛失败: " + response.message,
          type: "error",
        });
      }
      this.$loading.hide();
    },
    goto: function(link) {
      if (link == "") return;
      this.$router.push("/contest/" + link);
    },
  },
  async created() {
    await this.renderList();
    await this.getUserContestList();
  },
  filters: {
    timeFilter: function(val) {
      return val.slice(0, val.indexOf(" "));
    },
  },
};
</script>

<style lang="scss" scoped>
.contestlist {
  position: relative;
  width: 100%;
  height: 100%;
  overflow-x: hidden;
  overflow-y: scroll;
  padding: 88px 0 80px 25px;
}

.separator {
  display: flex;
  justify-content: center;
  /*align-items: center;*/
  height: 30px;
  width: 90%;
  min-width: 555px;
  max-width: 990px;
  margin: 0 auto 10px auto;
  > i {
    margin: 0 9%;
    /*width: calc(100% - 100px);*/
    font: {
      size: 17px;
      weight: bold;
    }
  }
  &::before {
    content: "<----------------------------- ";
    font: {
      size: 17px;
      style: italic;
    }
  }
  &::after {
    content: " ----------------------------->";
    font: {
      size: 17px;
      style: italic;
    }
  }
}

.contest-card {
  background: url("../../assets/media/contest.jpeg");
  border-radius: 0.5em;
  width: 90%;
  height: 180px;
  display: flex;
  align-items: center;
  margin: 0 auto 10px auto;
  overflow: hidden;
  min-width: 555px;
  max-width: 990px;
  cursor: pointer;
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
}

.contest-content {
  display: flex;
  flex-direction: column;
  position: relative;
  background: linear-gradient(
    -225deg,
    rgba(28, 28, 28, 0.6) 0%,
    rgba(48, 48, 48, 0.3) 100%
  );
  width: 100%;
  height: 100%;
}

.contest-title {
  position: relative;
  color: white;
  font-weight: bold;
  font-size: 25px;
  top: 30px;
  left: 30px;
}

.contest-sub-title {
  font-size: 18px;
  color: white;
  position: relative;
  top: 25px;
  left: 30px;
}

.content-words {
  display: flex;
  flex-direction: column;
}

.function-btn-group {
  position: relative;
  margin-top: 50px;
}

.join {
  /*left: 70%;*/
  /*position: relative;*/
  /*top: 95px;*/
  /*left: 58px;*/
  position: absolute;
  height: 40px;
  width: 120px;
  border: 2px solid rgba(250, 250, 250, 1);
  box-shadow: 0 3px 15px rgba(38, 38, 38, 0);
  background: rgba(38, 38, 38, 0.3);
  border-radius: 5px;
  font-weight: bold;
  color: white;
  cursor: pointer;
  right: 25px;
  left: auto;
}

.can-join:hover {
  text-decoration: underline;
}

.cant-join {
  text-decoration: none;
  border: 2px solid rgba(188, 188, 188, 1);
  color: rgba(188, 188, 188, 1);
  cursor: unset;
}

.has-join {
  border: 2px solid rgba(45, 183, 183, 1);
  color: rgba(45, 183, 183, 1);
  cursor: unset;
}

@media screen and (max-width: 650px) {
  .contestlist {
    padding-left: 10px;
    padding-right: 10px;

    & > * {
      font-family: PingFang SC;
      width: 100%;
      max-width: inherit;
      min-width: unset;
    }
  }

  .contest-card {
    width: 100%;
    height: 140px;
    border-radius: 15px;
    max-width: inherit;
    min-width: unset;

    .contest-content {
      width: 100%;
      height: 100%;

      .content-words {
        position: relative;
        top: unset;
        left: unset;
        padding: 10px 20px;

        & > * {
          top: unset;
          left: unset;
        }
        
        .contest-title {
          font-size: 18px;
          white-space: pre-wrap;
        }

        .contest-sub-title {
          font-size: 14px;
          top: 3px;
        }
      }
    }

    .function-btn-group > button {
      border-radius: 13px;
      border-width: 1.5px;
      width: 100px;
      height: 35px;
      font-weight: 400;
    }
  }

  .separator {
    justify-content: flex-start;
    width: 100%;
    &:after, &:before {
      content: '';
    }
    & > i {
      margin: 0 0 0 3px;
      font-size: 16px;
      font-style: normal;
    }
  }
}
</style>
