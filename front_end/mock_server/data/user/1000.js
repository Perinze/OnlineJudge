module.exports = function (method, data){
    if(method === "GET"){
        return {
            "status":0,
            "message":"查找成功",
            "data":{
            "user_id":1,
            "nick":"123",
            "realname":"1",
            "school":"test1",
            "major":"1",
            "class":"14",
            "desc":"14"
            }
        }
    }
    else if(method === "PUT"){
        return {
            "status":0,
            "message":"更新成功",
            "data":""
        }
    }
    
    
}