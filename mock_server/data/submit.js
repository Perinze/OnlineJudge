module.exports = function(method,data){
  if(method === "POST"){
    return {
      "status":0,
      "message":"提交成功",
      "data":""
    }
  }
  else if(mrthod === "GET"){
    return{
      "status":0
    }
  }
}