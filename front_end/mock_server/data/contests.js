module.exports = function(method, data){
    if(method === "GET"){
        return {
            "status": 0,
            "message": "查找成功",
            "data": [
              {
                "contest_id": 0,
                "contest_name": "wyh女装",
                "begin_time": "2019-11-16 12:30:00",
                "end_time": "2019-11-16 17:30:00",
                "frozen": 0.2,
                "problems": [
                  "1000",
                  "1001"
                ],
                "state": 0
              },
              {
                "contest_id": 1,
                "contest_name": "wyh女装",
                "begin_time": "2019-11-16 12:30:00",
                "end_time": "2019-11-16 17:30:00",
                "frozen": 0.2,
                "problems": [
                  "1000",
                  "1001"
                ],
                "colors": [
                  "#FFFFFF",
                  "#FF00FF"
                ],
                "state": 0
              },
              {
                "contest_id": 1002,
                "contest_name": "wyh女装",
                "begin_time": "2029-11-16 12:30:00",
                "end_time": "2029-11-16 17:30:00",
                "frozen": 0.2,
                "problems": [
                  "1000",
                  "1001"
                ],
                "colors": [
                  "#FFFFFF",
                  "#FF00FF"
                ],
                "state": 0
              }
            ]
          }
    }
    else if(method == "POST"){
        return {
            "status": 0,//0-success, -1-error
            "message": "新增比赛成功",
            "data": ""
        }
    }
}