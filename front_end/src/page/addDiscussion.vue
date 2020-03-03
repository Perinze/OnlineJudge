<template>
  <div class="container">
    <input type="text" class="title-input" placeholder="在此输入标题..." />
    <div id="editor"></div>
    <button class="btn-compelete">发布</button>
  </div>
</template>

<script>
import { loadScript, loadCss } from "../utils";

export default {
  name: "addDiscussion",
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