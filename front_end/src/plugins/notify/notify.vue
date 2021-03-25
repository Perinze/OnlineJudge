<template></template>
<script>
import getNotificationByID from "../../api/getData.js";
export default {
  name: "notify",
  data() {
    return {
      cid: this.$route.params.id,
      iswork: true,
      notice: "nothing",
    };
  },
  watch: {
    notice(newval) {
      this.$notify({
        title: "比赛通知",
        message: newval,
        duration: 0,
      });
    },
  },
  created() {
    this.intervalNotify();
  },
  methods: {
    intervalNotify() {
      let self = this;
      let interval = setInterval(() => {
        if (this.iswork) {
          getNotificationByID({contest_id:cid}).then((response) => {
            if (reseponse.status == 0) {
              self.notice = response.data.content;
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