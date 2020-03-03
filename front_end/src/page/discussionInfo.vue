<template>
  <div class="container">
    <h1 class="title">ACM新生赛</h1>
    <div class="info">
      <div
        class="info-content"
      >Here is the description of the algorithm. Here is the description of the algorithm.Here is the description of thedescrption of the aigorithm.Here is the description of thedescrption of the aigorithm.Here is the description of thedescrption of the aigorithm.Here is the description of the algorithm. Here is the description of the algorithm. Here is the description of th e algorithm. Here is the description of the algorithm. Here is the description of the algorithm. Here is the description of the algorithm.</div>
      <div class="imgs">
        <div class="img-item"></div>
        <div class="img-item"></div>
        <div class="img-item"></div>
        <div class="img-item"></div>
      </div>
      <button class="btn-add-discussion">评论</button>
    </div>
    <div class="discussion-list">
      <div class="discussion-list-item" v-for="item in discussions" :key="item.id">
        <div class="discussion-list-item-header">
          <div class="avatar"></div>
          <span class="name">{{item.id}}</span>
        </div>
        <p class="content">{{item.content}}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "discussionInfo",
  data() {
    return {
      discussions: [
        { id: 12, avatar: "", content: "This is a comment." },
        { id: 14, avatar: "", content: "This is a comment." },
        { id: 15, avatar: "", content: "This is a comment." }
      ]
    };
  }
};
</script>

<style lang="scss" scoped>
.container {
  padding: 44px 71px;
}
.info {
  width: 100%;
  padding: 30px 40px 66px 40px;
  background: rgba(237, 239, 243, 1);
  box-shadow: 0px 7px 9px 0px rgba(4, 0, 0, 0.1);
  border-radius: 15px;
  font-size: 18px;
  font-weight: 400;
  color: rgba(98, 98, 98, 1);
  margin-bottom: 30px;
}
.imgs {
  display: flex;
  flex-wrap: wrap;
}
.img-item {
  width: 291px;
  height: 163px;
  margin: 10px;
  flex-shrink: 0;
  background: #fff;
}
.btn-add-discussion {
  width: 111px;
  height: 26px;
  margin-top: 10px;
  background: rgba(66, 136, 206, 1);
  border-radius: 12px;
  font-size: 13px;
  font-weight: bold;
  color: rgba(255, 255, 255, 1);
  float: right;
}
.discussion-list {
  width: 100%;
  padding: 0 30px;
  background: rgba(251, 251, 251, 1);
  border-radius: 8px;
}
.discussion-list-item {
  padding: 0 10px;
  padding: 30px 0;
  border-bottom: 1px solid rgba(210, 210, 210, 1);
}
.discussion-list-item:last-of-type {
  border: none;
}
.discussion-list-item-header {
  display: flex;
  align-items: center;
  margin-bottom: 19px;
}
.avatar {
  width: 42px;
  height: 42px;
  background: rgba(170, 170, 170, 1);
  border-radius: 50%;
  margin-right: 11px;
}
.name {
  font-size: 20px;
  font-weight: bold;
  color: rgba(125, 125, 125, 1);
}
.content {
  font-size: 18px;
  font-weight: 400;
  color: rgba(98, 98, 98, 1);
  margin: 0;
}
</style>