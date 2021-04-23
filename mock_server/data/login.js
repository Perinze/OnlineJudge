module.exports =function(method, data){
    console.log(method);
    if(method === "GET"){
        return {
            "status": 0
        }
    }
    if(method === "POST"){
        return  {
            "status": 0,
            "message": "登录成功",
            "data": {
               "userId": 2,
                "nick": "kdl12138",
                "desc": "1234",
                "avatar": "null",
                "all_problems": [
                    {
                        "status": "WA",
                        "cnt": 1
                    }
                ]
            }
        }
    }
}
