module.exports = function (method, data){
    if(method === "GET"){
        return {
    "status": 0,//0-success, -1-error
    "message": "操作成功",
    "data": {
        "problem_id": 1002,
        "title": "A+B Problem",
        "background": "",
        "describe": "这是一个简单的A+B问题",
        "input_format": "多组输入，每组输入包含一行，行内有两个用空格隔开的数字a和b",
        "output_format": "每组输出一行，包含一个整数代表a+b的值",
        "hint": "",
        "public": 1,
        "source": null,
        "ac": 0,
        "wa": 0,
        "time": 1,          // s
        "type": "Normal",   // 对应Special Judge
        "tag": null,
        "status": 1,
        "memory": "32.0000",    // MB
        "sample": [
            {
                "sample_id": 1,
                "problem_id": 1001,
                "input": "wyhsb",
                "output": "wyhsb"
            },
            {
                "sample_id": 2,
                "problem_id": 1001,
                "input": "wyhsb",
                "output": "wyhsb"
            }
        ]
    }
}
}
    else if(method === "PUT"){
        return {
            "status": 0,//0-success, -1-error
            "message": "修改成功",
            "data": ""
        }
    }
}