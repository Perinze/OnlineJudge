import notify from './notify.vue'
export default {
  install(Vue) {
    const Notify=Vue.extend(notify);
    const Profile=new Notify();
    const notifyAction={
      start(){
        Profile.iswork=true;
      },
      stop(){
        Profile.iswork=false;
      }
    }
    Vue.prototype.$Notify=notifyAction;
  }
} 