<template>
  <div class="submission">
    <div class="submission-filter">
      <div>
        <label>用户nick: </label>
        <input type="text" class="filter-input" v-model="filters.nick" @keyup.enter="doFilter">
      </div>
      <div>
        <label>题目ID: </label>
        <input type="text" class="filter-input" v-model="filters.problemId" @keyup.enter="doFilter">
      </div>
      <div>
        <label>提交时间: </label>
        <el-date-picker
          class="submission-date-picker"
          v-model="filters.dateRange"
          format="yyyy-MM-dd"
          value-format="yyyy-MM-dd"
          type="daterange"
          start-placeholder="beginDays"
          end-placeholder="endDays"
        />
      </div>
      <button class="filter-button" @click="doFilter">确定</button>
    </div>
    <ul class="submission-list">
      <li
        v-for="(item, index) in list"
        :key="item.id + '' + index"
        class="submission-element"
      >
        <submission-card
          :avatar="item.avatar"
          :nick="item.nick"
          :memory="item.memory"
          :language="item.language"
          :problem-id="item.problem_id"
          :runid="item.runid"
          :status="item.status"
          :time="item.submit_time"
          :time-cost="item.time"
          :user-id="item.user_id"
        />
      </li>
    </ul>
    <div class="submission-pagination">
      <el-pagination
        v-if="counts > 0"
        background
        layout="prev, pager, next"
        :page-size="20"
        :total="counts"
        :current-page="currentPage"
        @current-change="changePage"
      />
    </div>
  </div>
</template>

<script>
import { getSubmitInfo } from "../api/getData";
import submissionCard from "../components/submission-card";
import _ from "lodash";

const lsKey = 'submission-list';

export default {
  name: "submission",
  props: {
    nick: String,
    user: String,
    status: String,
    problem: String,
    date: String
  },
  components: { submissionCard },
  data() {
    return {
      counts: 0,
      list: [],
      currentPage: 1,
      filters: {
        nick: null,
        problemId: null,
        dateRange: null
      }
    }
  },
  async created() {
    this.filters = Object.assign(this.filters, {
      nick: this.nick,
      problemId: this.problem,
      dateRange: this.formatDateRange(this.date)
    });
    await this.renderList();
  },
  methods: {
    formatDateRange(dateRange) {
      if (!this.date) return "";
      const [begin, end] = dateRange.split(',');
      return [begin, end];
    },
    doFilter() {
      let url = '/submission?';
      Object.keys(this.filters).forEach((key) => {
        if (this.filters[key]) {
          url += `${[...key][0]}=${this.filters[key]}&`;
        }
      });
      this.$router.push(url.slice(0, -1));
    },
    changePage(page) {
      document.getElementsByClassName('combox')[0].scrollTop = 0;
      this.renderList(page - 1);
      this.currentPage = page;
    },
    async renderList(page = 0) {
      try {
        this.$loading.open();
        const response = await getSubmitInfo({
          ...{
            nick: this.filters.nick,
            problem_id: this.filters.problemId,
            duration: this.filters.dateRange.length ? [
              this.filters.dateRange[0] + " 00:00:00",
              this.filters.dateRange[1] + " 23:59:59"
            ].join(",") : null
          },
          page: page
        });
        if (response.status === 0) {
          this.counts = response.data.count;
          this.list = response.data.submit_info;

          localStorage.setItem(lsKey, JSON.stringify(response.data));
        } else if (response.status === 504) {
          this.$message({
            type: "error",
            message: "请求超时，请检查网络后重试"
          });
        } else {
          this.$message({
            type: "error",
            message: "系统错误，请联系管理员"
          });
        }
      } catch (e) {
        this.$message({
          type: "error",
          message: "系统错误，请联系管理员"
        });
      } finally {
        this.$loading.hide();
      }
    }
  }
}
</script>

<style lang="scss" scoped>
  .submission {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 80px;
    padding-bottom: 40px;
    padding-left: 24px;
  }

  .submission-list {
    width: 100%;
    padding: 0;
    margin: 0 auto;
    list-style: none;
  }

  .submission-filter, .submission-element {
    width: 90%;
    max-width: 996px;
  }

  .submission-element, .submission-pagination {
    margin: 15px auto;
  }

  .submission-filter {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;

    label {
      font-weight: bolder;
    }

    .filter-input {
      border-radius: 4px;
      border: 1px solid #DCDFE6;
      width: 150px;
      height: 40px;
      padding: 0 15px;
    }

    .filter-button {
      border-radius: 4px;
      font-size: 16px;
      padding: 5px 20px;
      background: #4288ce;
      color: white;
      border: solid 1px #4288ce;
      cursor: pointer;
      &:hover {
        text-decoration: underline;
      }
    }
  }

  @media screen and (max-width: 650px) {
    .submission {
      padding: 88px 10px 20px 10px;
      width: 100%;
    }

    .submission-filter {
      width: 100%;
      flex-direction: column;
      align-items: flex-start;

      & > * {
        margin-bottom: 10px;

        label {
          display: inline-block;
          width: 70px;
        }
      }
    }

    .submission-element {
      width: 100%;
    }

    .submission-date-picker {
      width: 235px;
    }

    .submission-pagination {
      // width: 100%;
      margin: 15px 0;
    }
  }
</style>