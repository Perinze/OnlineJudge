module.exports = (method, data) => {
  return {
    "status": 0,
    "message": "登陆成功",
    "data": {
      "userId": 2,
      "nick": data.nick,
      "desc": "You blow me away.",
      "avatar": "",
      "all_problems": [
        {
          "status": "WA",
          "cnt": 1
        }
      ]
    }
  };
}