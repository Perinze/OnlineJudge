<template></template>
<script>
import { getNotificationByID } from "../../api/getData.js";
export default {
  name: "notify",
  data() {
    return {
      cid: "",
      iswork: true,
      tolog: false,
      resArr: [],
      notice: "nothing"
    };
  },
  watch: {
    notice(nval, oldval){
      this.$notify({
        title: nval.title,
        message: nval.content,
        duration: 0
      })
    }
  },
  created() {
    let storedNotice = localStorage.getItem("storedNotice");
    if(storedNotice != null){
      this.resArr = JSON.parse(storedNotice);
    }
    this.intervalNotify();
  },
  methods: {
    intervalNotify() {
      let self = this;
      let interval = setInterval(() => {
        if (this.iswork ) {
          if(this.cid != ""){
            getNotificationByID({contest_id: this.cid}).then((response) => {
              if (response.status == 0) {
                let res = response.data;
                console.log(res.length);
                if(res != undefined && res.length != 0){
                  for(let index in res){
                    self.resArr.push(res[index]);
                  }
                }
                if(self.resArr.length > 0){
                  console.log(self.resArr.length);
                  self.notice = self.resArr.shift();
                  console.log(self.resArr.length);
                }
                localStorage.setItem("storedNotice", JSON.stringify(self.resArr));
              }
            });
          }
          else{
              if(localStorage.getItem("nowContest") != null){
                this.cid = localStorage.getItem("nowContest");
                localStorage.removeItem("nowContest");
              }
              else this.cid = "";
          }
        } else {
          clearInterval(interval);
        }
      }, 5000);
    },
  },
};
</script>