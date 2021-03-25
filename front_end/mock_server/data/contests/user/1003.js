module.exports =function(method, data){
    if(method == "GET") {
        return{
            "data":{
                "contest_id":1003,
                "user_id":1001,
                "id":1,
                "status":0
            },
            "message":"查询成功",
            "status":0
        }
    }
    if(method == "POST") {
        return {
            "data":"",
            "msg":"参加比赛成功",
            "status":0
        }
    }
}