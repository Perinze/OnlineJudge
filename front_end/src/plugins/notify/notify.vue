<template></template>
<script>
import getNotificationByID from "../../api/getData.js";
export default {
  name: "notify",
  data() {
    return {
      cid: this.$route.params.id,
      iswork: true,
      notice: [],
    };
  },
  watch: {
    notice:{
      handler(newval) {
        for(let index in newval){
          this.$notify({
            title: newval[index].title,
            message: newval[index].content,
            duration: 3000
          });
        }
      },
      deep: true
    }
  },
  created() {
    let storedNotice = localStorage.getItem("storedNotice");
    if(storedNotice != null){
      this.notice = JSON.parse(storedNotice);
    }
    this.intervalNotify();
  },
  methods: {
    intervalNotify() {
      let self = this;
      let interval = setInterval(() => {
        if (this.iswork) {
          getNotificationByID({contest_id:cid}).then((response) => {
            if (reseponse.status == 0) {
              let resArr= response.data;
              if(resArr != undefined && resArr.length != 0){
                for(let index in resArr){
                  self.notice.push(resArr[index]);
                }
              }
              localStorage.setItem("storedNotice", JSON.stringify(self.notice));
            }
          });
        } else {
          clearInterval(interval);
        }
      }, 5000);
    },
  },
};
</script>