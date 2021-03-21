module.exports = function(method, data){
    if(method === "GET"){
        return {
    "status":0,
    "message":"查询成功",
    "data":{
    "data":[
    {
        "id":1,
        "problem_id":1001,
        "user_id":1,
        "nick":"123",
        "title":"wyhsb",
        "content":"wyhsb",
        "time":"2019-10-13 15:49:45",
        "status":1
    },
    {
        "id":2,
        "problem_id":1001,
        "user_id":1,
        "nick":"123",
        "title":"wyhsb",
        "content":"wyhsb",
        "time":"2019-10-13 15:56:46",
        "status":0
    },
    {
        "id":3,
        "problem_id":1001,
        "user_id":2,
        "nick":"kdl12138",
        "title":"ssss",
        "content":"wyhsb",
        "time":"2019-10-13 15:59:34",
        "status":0
    },
    {
        "id":4,
        "problem_id":1001,
        "user_id":1,
        "nick":"123",
        "title":"ssss",
        "content":"wyhsb",
        "time":"2019-10-13 16:00:31",
        "status":8
    }
    ],
    "count":4,
    }
}
    
}
    else if (method === "POST"){
        return {
            "status": 0,//0-success, -1-error
            "message": "添加成功",
            "data": ""
        }
    }
}