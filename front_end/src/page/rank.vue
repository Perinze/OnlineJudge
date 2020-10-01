<template>
  <div class="container">
    <div class="rank-top">
      <div class="rank-top-item">
        <div class="avatar"></div>
        <div class="name"></div>
        <div class="top-first-step top-step">
          <h5 class="top-rank">2</h5>
          <div class="top-datas">
            <div class="top-data">星数: 12</div>
            <div class="top-data">AC数: 24</div>
          </div>
        </div>
      </div>
      <div class="rank-top-item">
        <div class="avatar"></div>
        <div class="name"></div>
        <div class="top-second-step top-step">
          <h5 class="top-rank">1</h5>
          <div class="top-datas">
            <div class="top-data">星数: 12</div>
            <div class="top-data">AC数: 24</div>
          </div>
        </div>
      </div>
      <div class="rank-top-item">
        <div class="avatar"></div>
        <div class="name"></div>
        <div class="top-third-step top-step">
          <h5 class="top-rank">3</h5>
          <div class="top-datas">
            <div class="top-data">星数: 12</div>
            <div class="top-data">AC数: 24</div>
          </div>
        </div>
      </div>
    </div>
    <div class="table">
      <el-table
        :data="ranks"
        style="width: 100%;"
        :header-cell-style="{
          fontSize: 18 + 'px',
          fontWeight: 'bold',
          color: 'rgba(125,125,125,1)',
        }"
        :cell-style="{
          fontSize: 15 + 'px',
          fontWeight: '400',
          color: 'rgba(125,125,125,1)',
        }"
      >
        <el-table-column label="排名" prop="position"></el-table-column>
        <el-table-column label="ID" prop="id"></el-table-column>
        <el-table-column label="星数" prop="waCnt"></el-table-column>
        <el-table-column label="AC数" prop="acCnt"></el-table-column>
      </el-table>
      <pagination :total="70" :pageSize="10" :pageCount="7"></pagination>
    </div>
  </div>
</template>

<script>
import pagination from "../components/pagination";

export default {
  name: "rank",
  components: { pagination },
  data() {
    return {
      ranks: [
        { id: 1, position: 2, waCnt: 20, acCnt: 30 },
        { id: 1, position: 2, waCnt: 20, acCnt: 30 },
        { id: 1, position: 2, waCnt: 20, acCnt: 30 },
      ],
    };
  },
};
</script>

<style lang="scss" scoped>
.container {
  padding: 0 97px;
}
.rank-top {
  display: flex;
  justify-content: center;
  align-items: flex-end;
  margin-top: 117px;
  margin-bottom: 31px;
}
.rank-top-item {
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  align-items: center;
}
.avatar {
  width: 57px;
  height: 57px;
  background: rgba(255, 255, 255, 1);
  box-shadow: 0px 0px 11px 1px rgba(4, 0, 0, 0.1);
  border-radius: 50%;
  margin-bottom: 15px;
}
.name {
  font-size: 15px;
  font-weight: 400;
  color: rgba(125, 125, 125, 1);
  margin-bottom: 15px;
}
.top-step {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
  padding: 5px;
}
.top-first-step {
  width: 227px;
  height: 104px;
  background: rgba(228, 86, 86, 1);
  border-radius: 12px 0px 0px 0px;
}
.top-second-step {
  width: 227px;
  height: 144px;
  background: rgba(66, 136, 206, 1);
  border-radius: 12px 12px 0px 0px;
}
.top-third-step {
  width: 227px;
  height: 84px;
  background: rgba(255, 185, 95, 1);
  border-radius: 0px 12px 0px 0px;
}
.top-rank {
  font-size: 18px;
  font-weight: bold;
  color: rgba(255, 255, 255, 1);
  margin: 0;
}
.top-data {
  font-size: 15px;
  font-weight: bold;
  color: rgba(255, 255, 255, 1);
}
.table {
  width: 100%;
  padding: 22px 21px;
  background: #fff;
  border-radius: 8px;
}
</style>
