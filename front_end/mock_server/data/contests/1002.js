module.exports =function(method,data){
    if(method === "GET"){
        return {
            "status": 0,//0-success, -1-error
            "message": "查找成功",
            "data": {
                "contest_id": 1002,
                "contest_name": "wyh女装",
                "begin_time": "2029-11-16 12:30:00",
                "end_time": "2029-11-16 17:30:00",
                "frozen": 0.2,//封榜百分比
                "problems":[
                   "1000",
                    "1001"
                ],
            "colors": [
                "#eeeeee",
                "#aaaaaa"
            ],
            "status": 1// 1-有效，0-比赛被禁止
            }
        }
    }
    else if(method === "DELETE"){
        return {
            "status": 0,//0-success, -1-error
            "message": "删除比赛成功",
            "data": ""
        }
    }
    else if(method === "PUT"){
        return {
            "status": 0,//0-success, -1-error
            "message": "更新比赛成功",
            "data": ""
        }
    }
}