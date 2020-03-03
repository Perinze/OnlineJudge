<template>
  <div class="pagination" v-if="total - pageSize > 0 && total - 0 > 0">
    <div class="pagination-btn-start pagination-block">
      <img src="../../assets/media/arrow-start.png" />
    </div>
    <div class="pagination-btn-prev pagination-block">
      <img src="../../assets/media/arrow-prev.png" />
    </div>
    <div class="pagination-block" style="cursor: auto" v-if="pageNum.length - pageCount > 0">···</div>
    <div
      :class="['pagination-block', item == index ? 'pagination-block-active' : '']"
      v-for="item in pageNum"
      :key="item"
    >{{item}}</div>
    <div class="pagination-btn-next pagination-block">
      <img src="../../assets/media/arrow-next.png" />
    </div>
    <div class="pagination-block" style="cursor: auto" v-if="pageNum.length - pageCount > 0">···</div>
    <div class="pagination-btn-end pagination-block">
      <img src="../../assets/media/arrow-end.png" />
    </div>
  </div>
</template>

<script>
export default {
  name: "pagination",
  props: ["total", "pageSize", "pageCount"],
  data() {
    return {
      index: 1
    };
  },
  computed: {
    pageNum: function() {
      let arr = [],
        pages = Math.ceil(this.total / this.pageSize);
      for (let i = 1; i <= pages; i++) {
        arr.push(i);
      }
      return arr;
    }
  }
};
</script>

<style lang="scss" scoped>
.pagination {
  width: 100%;
  margin-top: 26px;
  margin-bottom: 12px;
  display: flex;
  justify-content: center;
}
.pagination-block {
  width: 35px;
  height: 35px;
  margin: 0 15px;
  background: rgba(238, 238, 238, 1);
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 13px;
  font-weight: 400;
  color: rgba(160, 160, 160, 1);
  cursor: pointer;
}
.pagination-block:first-of-type {
  margin-left: 0;
}
.pagination-block:last-of-type {
  margin-right: 0;
}
.pagination-block-active {
  background: rgba(66, 136, 206, 1);
  color: rgba(255, 255, 255, 1);
}
.pagination-btn-start > img,
.pagination-btn-end > img {
  width: 13px;
  height: 13px;
}
.pagination-btn-prev > img,
.pagination-btn-next > img {
  width: 7.5px;
  height: 13px;
}
</style>