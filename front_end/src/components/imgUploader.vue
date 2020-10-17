<template>
  <div class="img-uploader" v-if="isDisplay">
    <div class="mask"></div>
    <div class="editor-main">
      <div id="cropper-container">
        <img
          id="img-need-to-crop"
          :src="imgSrc"
          ref="imgNeedCrop"
          width="900"
          height="600"
        />
      </div>
      <div class="btn-group">
        <button id="submit-btn" @click="submit">提交</button>
        <button id="cancel-btn" @click="$emit('close')">取消</button>
      </div>
    </div>
  </div>
</template>

<script>
import CropperJs from "cropperjs";
require("cropperjs/dist/cropper.css");
export default {
  name: "img-uploader",
  props: {
    isDisplay: {
      type: Boolean,
      default: false,
    },
    imgSrc: {
      type: String,
      default: null,
    },
    aspectRatio: {
      type: Number,
      default: 1,
    },
  },
  data() {
    return {
      cropper: null,
      cropped: null,
    };
  },
  methods: {
    init() {
      this.cropper = new CropperJs(
        document.getElementById("img-need-to-crop"),
        {
          aspectRatio: 1, // 宽高比
          viewMode: 1,
        }
      );
    },
    submit() {
      const that = this;
      const canvas = this.cropper.getCroppedCanvas();
      const base64 = canvas.toDataURL('image/jpeg');
      const img = new Image();
      img.onload = function (event) {
        that.$emit("submit", {
          base64,
          obj: event.target
        });
      };
      img.src = base64;
    },
  },
  watch: {
    isDisplay(val) {
      if (val) {
        this.$nextTick(() => {
          this.init();
        });
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.img-uploader {
  position: fixed;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1500;
}

.btn-group {
  position: fixed;
  margin-top: -600px;
  > button {
    width: 100px;
    height: 35px;
    margin-left: 910px;
    margin-bottom: 10px;
    background: white;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    &:hover {
      text-decoration: underline;
    }
  }
  z-index: 3;
}

.mask {
  position: fixed;
  background: rgba(255, 255, 255, 0.4);
  height: 100%;
  width: 100%;
  z-index: 1;
}

.editor-main {
  border-radius: 0.8em;
  width: 900px;
  height: 600px;
  background: white;
  z-index: 2;
  filter: drop-shadow(5px 10px 5px rgba(0, 0, 0, 0.3));
}

#cropper-container {
  overflow: hidden;
  border-radius: 0.8em;
}
</style>
