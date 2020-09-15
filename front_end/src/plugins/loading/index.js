import loading from "./loading";
export default {
  install(Vue, options) {
    /**
     * 使用基础 Vue.extend 构造器，创建一个“子类” (Loading)。
     * 参数是一个包含组件选项的对象(myLoading)。
     * 然后 创建一个 Loading 的实例 Profile 挂载到一个HTMLElement实例上
     */
    const Loading = Vue.extend(loading);
    const Profile = new Loading({
      el: document.createElement("div"),
    });

    /**
     * loading.vue中的template模板内容将会替换挂载的元素。挂载元素的内容都将被忽略。
     * 所以Profile.$el最终是template里面的内容
     */
    document.body.appendChild(Profile.$el);

    if (options) {
      if (options.progressColor) Profile.progressColor = options.progressColor;
    }

    const loadingMethod = {
      open() {
        Profile.show = true;
      },
      hide() {
        Profile.show = false;
      },
    };
    Vue.prototype.$loading = loadingMethod;
  },
};
