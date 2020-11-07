<template>
</template>
<script>
import getNotification from '.../api/getData.js'
export default {
  name: "notify",
  props:{
    cid:String
  },
  data() {
    return {
      iswork:true,
      notice:'nothing'
    }
  },
  watch:{
    notice(newval){
      this.$notify({
      title:'比赛通知',
      message:newval,
      duration:0
      })
    }
  },
  created() {
    this.intervalNotify();
  },
  methods: {
    intervalNotify() {
      let self=this;
      let interval=setInterval(()=>{ 
        if(this.iswork){
        getNotificationByID(cid).then((response)=>{
            if(reseponse.status==0){
              self.notice=response.data.content;
            }
        })
        } else{
          clearInterval(interval);
        }
        },5000)
      }
  }
}
</script>