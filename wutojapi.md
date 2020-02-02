# api

[toc]

## contest

* getAllContest

*request:*
null

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "查找成功",
    "data": [
        {
            "contest_id": 0,
            "contest_name": "wyh女装",
            "begin_time": "2019-11-16 12:30:00",
            "end_time": "2019-11-16 17:30:00",
            "frozen": 0.2,//封榜百分比
            "problems":[
                "1000",
                "1001",
            ],
            "state": 0// 0-有效，1-比赛被禁止
        },
        {
            "contest_id": 0,
            "contest_name": "wyh女装",
            "begin_time": "2019-11-16 12:30:00",
            "end_time": "2019-11-16 17:30:00",
            "frozen": 0.2,//封榜百分比
            "problems":[
                "1000",
                "1001",
            ],
            "colors": [
                "#FFFFFF",
                "#FF00FF"
            ],
            "state": 0// 0-有效，1-比赛被禁止
        }
    ]
}
```

* getTheContest

*request:*

```json
{
    "contest_id": 1000
}
```

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "查找成功",
    "data": {
        "contest_id": 1000,
        "contest_name": "wyh女装",
        "begin_time": "2019-11-16 12:30:00",
        "end_time": "2019-11-16 17:30:00",
        "frozen": 0.2,//封榜百分比
        "problems":[
            "1000",
            "1001",
        ],
        "colors": [
            "#eeeeee",
            "#aaaaaa"
        ],
        "status": 1// 1-有效，0-比赛被禁止
    }
}
```

* searchContest

*request:*

``` json
{
    "contest_name": "wyh女装"
}
```

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "查找成功",
    "data": [
        "contest_id": 0,
        "contest_name": "wyh女装",
        "begin_time": "2019-11-16 12:30:00",
        "end_time": "2019-11-16 17:30:00",
        "frozen": 0.2,//封榜百分比
        "problems":[
            "1000",
            "1001",
        ],
        "colors": [
            "#eeeeee",
            "#aaaaaa"
        ],
        "state": 1// 1-有效，0-比赛被禁止
    ]
}
```

* addContest

*request:*

``` json
{
    "contest_name": "wyh女装",
    "begin_time": "2019-11-17 12:30:00",
    "end_time": "2019-11-17 17:30:00",
    "frozen": 0.2,
    "problems":[
        "1000",
        "1001",
    ],
    "colors": [
        "#eeeeee",
        "#aaaaaa"
    ],
}
```

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "新增比赛成功",
    "data": ""
}
```

* deleteContest

*request:*

``` json
{
    "contest_id": 1000
}
```

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "删除比赛成功",
    "data": ""
}
```

* updateContest

*request:*

``` json
{
    "contest_id": 1000,
    "contest_name": "wyh女装",
    "begin_time": "2019-11-17 12:30:00",
    "end_time": "2019-11-17 17:30:00",
    "frozen": 0.2,
    "problems":[
        "1000",
        "1001",
    ],
    "colors": [
        "#eeeeee",
        "#aaaaaa"
    ],
    "state": 1// 1-有效，0-比赛被禁止
}
```

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "更新比赛成功",
    "data": ""
}
```

* joinContest

*request:*

``` json
{
    "contest_id": 1000,
}
```

*response:*

``` json
{
    "status": 0,//0-成功，1-失败
    "message": "已参加比赛",
    "data": ""
}
```

* checkContest

*request:*

``` json
{
    "contest_id": 1000,
}
```

*response:*

``` json
{
    "status": 0,//0-成功，1-失败
    "message": "已参加比赛",
    "data": ""
}
```

* getUserContest

*request:*

null

*response:*

``` json
{
    "status": 0,
    "message": "查询成功",
    "data": [
        {
            "id": 1,
            "contest_id": 1001,
            "user_id": 1
        },
        {
            "id": 3,
            "contest_id": 1002,
            "user_id": 1
        }
    ]
}
```

## Group

* get_all_group

*request:*

null

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "查询成功",
    "data": {
        "group_id": 0,
        "group_name": "wyh女装",
        "desc": "wyh女装协会",
        "group_creator": 0,
        "state": 0
    }
}
```

* user_get_all_group

*request:*

null

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "查询成功",
    "data": {
        "group_id": 0,
        "group_name": "wyh女装",
        "desc": "wyh女装协会",
        "group_creator": 0,
        "state": 0
    }
}
```

* get_the_group

*request:*

``` json
{
    "group_id": 1000
}
```

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "查询成功",
    "data": {
        "user": {
            0: {
                "user_id": 1,
                "nick": "wyh女装",
                "realname": "wyh女装",
                "school": "女装大学",
                "major": "女装",
                "class": "女装1班",
                "contact": "13256456654",
                "identity": 0,
                "desc": "wyh特别喜欢女装",
                "mail": "wyhnz@163.com",
                "ac_problem": {
                    0: 1000,
                    1: 1001
                },
                "wa_problem": {
                    0: 1000,
                    1: 1001,
                    2: 1002
                },
                "wa_num": 10,
                "submit_data": {
                    0: 1000,
                    1: 1001,
                    2: 1002,
                }
            },
            1: 1
        },
        "group_name": "wyh女装",
        "desc": "wyh女装协会",
        "group_creator": 0,
        "state": 0
    }
}
```

* get_the_group

*request:*

``` json
{
    "group_id": 1000
}
```

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "查询成功",
    "data": {
        "user": {
            0: {
                "user_id": 1,
                "nick": "wyh女装",
                "realname": "wyh女装",
                "school": "女装大学",
                "major": "女装",
                "class": "女装1班",
                "contact": "13256456654",
                "identity": 0,
                "desc": "wyh特别喜欢女装",
                "mail": "wyhnz@163.com",
                "ac_problem": {
                    0: 1000,
                    1: 1001
                },
                "wa_problem": {
                    0: 1000,
                    1: 1001,
                    2: 1002
                },
                "wa_num": 10,
                "submit_data": {
                    0: 1000,
                    1: 1001,
                    2: 1002,
                }
            },
            1: {
                "user_id": 2,
                "nick": "wyh女装",
                "realname": "wyh女装",
                "school": "女装大学",
                "major": "女装",
                "class": "女装1班",
                "contact": "13256456654",
                "identity": 0,
                "desc": "wyh特别喜欢女装",
                "mail": "wyhnz@163.com",
                "ac_problem": {
                    0: 1000,
                    1: 1001
                },
                "wa_problem": {
                    0: 1000,
                    1: 1001,
                    2: 1002
                },
                "wa_num": 10,
                "submit_data": {
                    0: 1000,
                    1: 1001,
                    2: 1002,
                }
            },
        },
        "group_name": "wyh女装",
        "desc": "wyh女装协会",
        "group_creator": 0,
        "state": 0
    }
}
```

* add_group

*request:*

``` json
{
    "group_name": "wyh女装",
    "desc": "wyh女装"
}
```

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "查询成功",
    "data": ""
}
```

* join_group

*request:*

``` json
{
    "group_id": 1000
}
```

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "加入成功",
    "data": ""
}
```

* out_group

*request:*

``` json
{
    "group_id": 1000,
}
```

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "退出成功",
    "data": ""
}
```

* accept

*request:*

``` json
{
    "group_id": 1000,
    "user_id": 1
}
```

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "操作成功",
    "data": ""
}
```

## Index

* notice

*request:*
null

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "操作成功",
    "data": {
        0:{
            "id": 1,
            "title": "wyh女装",
            "contest": "wyh决定明天女装了",
            "link": "",
            "begintime": "2019-11-16 00:00:00",
            "endtime": "2019-11-30 00:00:00"
        }
    }
}
```

* rotation

*request:*
null

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "操作成功",
    "data": [
        {
            "id": 1,
            "title": "test",
            "url": "xxx",
            "status": 1// 1-有效
        },
        {
            "id": 3,
            "title": "test",
            "url": "xxxxx",
            "status": 1
        },
        {
            "id": 4,
            "title": "test",
            "url": "xxxx",
            "status": 1
        },
        {
            "id": 5,
            "title": "test",
            "url": "xxxxx",
            "status": 1
        }
    ]
}
```

* data

*request:*
null

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "操作成功",
    "data": [
        {
            "time": "2019-10-14 00:00:00",
            "ac": 0,
            "submit": 0
        },
        {
            "time": "2019-10-15 00:00:00",
            "ac": 0,
            "submit": 0
        },
        {
            "time": "2019-10-13 00:00:00",
            "ac": 0,
            "submit": 0
        },
        {
            "time": "2019-10-12 00:00:00",
            "ac": 0,
            "submit": 0
        },
        {
            "time": "2019-10-11 00:00:00",
            "ac": 0,
            "submit": 0
        },
        {
            "time": "2019-10-10 00:00:00",
            "ac": 0,
            "submit": 0
        },
        {
            "time": "2019-10-09 00:00:00",
            "ac": 0,
            "submit": 0
        },
        {
            "time": "2019-10-08 00:00:00",
            "ac": 0,
            "submit": 0
        },
        {
            "time": "2019-10-07 00:00:00",
            "ac": 0,
            "submit": 0
        },
        {
            "time": "2019-10-06 00:00:00",
            "ac": 0,
            "submit": 0
        },
        {
            "time": "2019-10-05 00:00:00",
            "ac": 0,
            "submit": 0
        },
        {
            "time": "2019-10-04 00:00:00",
            "ac": 0,
            "submit": 0
        },
        {
            "time": "2019-10-03 00:00:00",
            "ac": 0,
            "submit": 0
        },
        {
            "ac": 2715,
            "submit": 38271
        }
    ]
}
```

## login

* do_login

*request:*

``` json
{
    "nick": "wyhnz",
    "password": "wyhnznb"
}
```

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "登录成功",
    "data": {
        "userId": 1,
        "nick": "123",
        "desc": null,
        "acCnt": 0,
        "waCnt": 0
    }
}
```

* do_logout

*request:*
null

*response:*

``` json
{
    "status": 0,
    "message": "注销成功",
    "data": ""
}
```

* forgetPassword

*request:*

``` json
{
    "nick": "wyhnz",
    "mail": "wyhnz@1653.com"
}
```

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "发送成功",
    "data": ""
}
```

## Problem

* displayAllProblem

*request:*

null

*response:*

``` json
{
    "status": 0,
    "message": "查找成功",
    "data": [
        {
            "problem_id": 1000,
            "title": "wyhsb",
            "tag": null,
            "ac": 1,
            "wa": 0,
            "tle": 0,
            "mle": 0,
            "re": 0,
            "se": 0,
            "ce": 0
        },
        {
            "problem_id": 1001,
            "title": "wyhsb",
            "tag": null,
            "ac": 1,
            "wa": 0,
            "tle": 0,
            "mle": 0,
            "re": 0,
            "se": 0,
            "ce": 0
        },
        {
            "problem_id": 1002,
            "title": "wyhsb",
            "tag": null,
            "ac": 0,
            "wa": 2,
            "tle": 0,
            "mle": 0,
            "re": 0,
            "se": 0,
            "ce": 0
        }
    ]
}
```

* displayProblem

*request:*

``` json
{
    "problem_id": 1001,
}
```

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "操作成功",
    "data": {
        "problem_id": 1001,
        "title": "wyhsb",
        "background": "wyhsb",
        "describe": "wyhsb",
        "input_format": "wyhsb",
        "output_format": "wyhsb",
        "hint": "wyhsb",
        "public": 1,
        "source": null,
        "ac": 0,
        "wa": 0,
        "tag": null,
        "status": 1,
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
```

* searchProblem

*request:*

```json
{
    "search": "xxx"//可以是id，也可以是标题
}
```

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "操作成功",
    "data": [
        {
            "problem_id": 1001,
            "title": "wyhsb",
            "ac": 0,
            "wa": 0,
            "tag": null
        },
        {
            "problem_id": 1002,
            "title": "wyhsb",
            "ac": 0,
            "wa": 0,
            "tag": null
        }
    ]
}
```

* newProblem

*request:*

```json
{
    "title": "wyh女装",
    "background": "wyh想要女装了",
    "describe": "描述",
    "input_format": "sxxsasfc",//可为空
    "output_format": "ssdds",//可为空
    "hint": "",//可为空
    "ac": 100,
    "wa": 1000,
    "source": "",//可为空
    "tag": "女装",
}
```

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "添加成功",
    "data": ""
}
```

* editProblem

*request:*

```json
{
    "problem_id": 1,
    "title": "wyh女装",
    "background": "wyh想要女装了",
    "describe": "描述",
    "input_format": "sxxsasfc",//可为空
    "output_format": "ssdds",//可为空
    "hint": "",//可为空
    "ac": 100,
    "wa": 1000,
    "source": "",//可为空
    "tag": "女装",
}
```

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "修改成功",
    "data": ""
}
```

## Rank //要更新逻辑

* userRank

* groupRank

* contest_rank

  *request:*

  ``` json
  {
      "contest_id": 1001
  }
  ```

  *response:*

  ``` json
  {
      "status": 0,
      "message": "获取排行榜成功",
      "data": {
          "array": ["0": {
              "user_id": 1,
              "nick": "",
              "penalty": -17205167,
              "ac_num": 1,
              "problem_id": [
                  {
                      "problem_id": "A",
                      "success_time": -17205167,
                      "times": 0
                  },
                  {
                      "problem_id": "B",
                      "success_time": "",
                      "times": 1
                  }
              ]
          },
          "1": {
              "user_id": 2,
              "nick": "",
              "penalty": 0,
              "ac_num": 0,
              "problem_id": [
                  {
                      "problem_id": "B",
                      "success_time": "",
                      "times": 1
                  }
              ]
          },]
          "problems": [
              "1001",
              "1002"
          ]
      }
  }
  ```

  

## Register

* register

*request:*

```json
{
    "nick": "wyhnz",
    "password": "xxxxx",
    "password_check": "xxxxx",
    "realname": "wyh",
    "school": "女装",
    "major": "女装",
    "class": "女装1班",
    "contact": "13132545445",
    "mail": "wyhnz@163.com",
}
```

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "注册成功",
    "data": ""
}
```

## User

* adduser

* searchUser

  *request:*

  ```json
  {
      "user_id": 1,
      "nick": "wyhsb" // 与user_id选择一个
  }
  ```

  *response:*

  ```json
  {
      "status": 0,
      "message": "查找成功",
      "data": {
          "user_id": 1,
          "nick": "123",
          "realname": "1",
          "school": "test1",
          "major": "1",
          "class": "14",
          "desc": "14",
          "ac_num": 0,
          "wa_num": 0
      }
  }
  ```

  

* edituser

  *request:*

  ``` json
  {
      "realname": "wyhsb",
      "school": "wyhsb",
      "major": "wyhsb",
      "class": "wyhsb",
      "desc": "wyhsb"
  }
  ```

  

  *response:*

  ``` json
  {
      "status": 0,
      "message": "更新成功",
      "data": ""
  }
  ```

  

* change_password

  *request:*

  ``` json
  {
      "nick": "wyhsb",
      "old_password": "wyhsb",
      "password": "1001",
      "password_check": "1001",
}
  ```

  *response:*
  
  ``` json
  {
      "status": 0,
      "message": "更新成功",
      "data": ""
}
  ```
  
  

## discuss

* add_discuss

*request:*

```json
{
    "contest_id": "1001",
    "problem_id": "1001",
    "content": "xxxxx",
    "title": "wyh",
}
```

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "添加成功",
    "data": ""
}
```

* add_reply

*request:*

```json
{
    "id": "1",
    "content": "xxxxx",
}
```

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "添加成功",
    "data": ""
}
```

* getAllDiscuss

*request:*

```json
{
    "contest_id": "1001",
}
```

*response:*

``` json
{
    "status": 0,
    "message": "查询成功",
    "data": [
        {
            "id": 1,
            "problem_id": 1001,
            "contest_id": 1001,
            "user_id": 1,
            "nick": "123",
            "title": "wyhsb",
            "content": "wyhsb",
            "time": "2019-10-13 15:49:45",
            "status": 1
        },
        {
            "id": 2,
            "problem_id": 1001,
            "contest_id": 1001,
            "user_id": 1,
            "nick": "123",
            "title": "wyhsb",
            "content": "wyhsb",
            "time": "2019-10-13 15:56:46",
            "status": 0
        },
        {
            "id": 3,
            "problem_id": 1001,
            "contest_id": 1001,
            "user_id": 2,
            "nick": "kdl12138",
            "title": "ssss",
            "content": "wyhsb",
            "time": "2019-10-13 15:59:34",
            "status": 0
        },
        {
            "id": 4,
            "problem_id": 1001,
            "contest_id": 1001,
            "user_id": 1,
            "nick": "123",
            "title": "ssss",
            "content": "wyhsb",
            "time": "2019-10-13 16:00:31",
            "status": 8
        }
    ]
}
```

* getTheDiscuss

*request:*

```json
{
    "discuss_id": "1",
}
```

*response:*

``` json
{
    "status": 0,
    "message": "查询成功",
    "data": [
        {
            "id": 1,
            "problem_id": 1001,
            "contest_id": 1001,
            "user_id": 1,
            "nick": "123",
            "title": "wyhsb",
            "content": "wyhsb",
            "time": "2019-10-13 15:49:45",
            "status": 1
        },
        [
            {
                "id": 1,
                "user_id": 1,
                "nick": "123",
                "discuss_id": 1,
                "content": "wyhqssb",
                "time": "2019-10-13 15:52:12"
            },
            {
                "id": 2,
                "user_id": 1,
                "nick": "123",
                "discuss_id": 1,
                "content": "wyhsb",
                "time": "2019-10-13 16:02:05"
            },
            {
                "id": 3,
                "user_id": 1,
                "nick": "123",
                "discuss_id": 1,
                "content": "wyhsb",
                "time": "2019-10-13 16:02:43"
            }
        ]
    ]
}
```

* getUserDiscuss

  *request:*

  ``` json
  {
      "contest_id": 1001
  }
  ```

  

  *response:*

  ``` json
  {
      "status": 0,
      "message": "查询成功",
      "data": [
          {
              "id": 1,
              "problem_id": 1001,
              "contest_id": 1001,
              "user_id": 1,
              "nick": "123",
              "title": "wyhsb",
              "content": "wyhsb",
              "time": "2019-10-13 15:49:45",
              "status": 1
          },
          {
              "id": 2,
              "problem_id": 1001,
              "contest_id": 1001,
              "user_id": 1,
              "nick": "123",
              "title": "wyhsb",
              "content": "wyhsb",
              "time": "2019-10-13 15:56:46",
              "status": 0
          },
          {
              "id": 4,
              "problem_id": 1001,
              "contest_id": 1001,
              "user_id": 1,
              "nick": "123",
              "title": "ssss",
              "content": "wyhsb",
              "time": "2019-10-13 16:00:31",
              "status": 8
          }
    ]
  }
  ```
  
  

## Submit

* submit

  *request:*

  ``` json
  {
      "language": "cpp.g++",
      "source_code":"xxx",
      "problem_id": "1001",
      "contest_id": "1000", // 可选
  }
  ```

  *response:*

  ``` json
  {
      "status": 0,
      "message": "提交成功",
      "data": ""
  }
  ```

> 语言参数列表:
> C++11: cpp.g++ 
> C98: c.gcc
> Python3.6: py.cpython
> Java: java.java 


* get_submit_info

*request:*

```json
{
    "contest_id": "1",//可选
    "user_id": "1", //可选
    "page": 1//可选,默认第一面
}
```

*response:*

* contest_id and user_id 获取指定用户比赛提交，若在比赛期间，只有管理员可使用，其他调用返回个人提交，若比赛结束，普通用户和管理员等效

``` json
{
    "status": 0,
    "message": "查询成功",
    "data": {
        "submit_info": [
            {
                "runid": 1,
                "user_id": 1,
                "nick": "123",
                "problem_id": 1001,
                "language": "c++",
                "status": "AC",
                "time": "",
                "memory": "",
                "submit_time": "2019-03-31 13:00:00"
            },
            {
                "runid": 1,
                "user_id": 1,
                "nick": "123",
                "problem_id": 1002,
                "language": "c++",
                "status": "WA",
                "time": "",
                "memory": "",
                "submit_time": "2019-03-31 13:00:00"
            }
        ],
        "penalty": {
            "nick": "123",
            "penalty": -17205167,
            "acnum": 1,
            "problem": {
                "A": {
                    "success_time": -17205167,
                    "times": 0
                },
                "B": {
                    "success_time": "",
                    "times": 1
                }
            }
        }
    }
}
```

* user_id 获取指定用户非比赛提交

``` json
{
    "status": 0,
    "message": "查询成功",
    "data": [
        {
            "runid": 1,
            "user_id": 1,
            "nick": "123",
            "problem_id": 1001,
            "language": "c++",
            "status": "AC",
            "time": "",
            "memory": "",
            "submit_time": "2019-03-31 13:00:00"
        },
        {
            "runid": 1,
            "user_id": 1,
            "nick": "123",
            "problem_id": 1002,
            "language": "c++",
            "status": "WA",
            "time": "",
            "memory": "",
            "submit_time": "2019-03-31 13:00:00"
        }
    ]
}
```

* contest_id 如果是管理员或比赛已结束则得到指定比赛的所有提交，如果是普通用户在比赛时间内则返回普通用户该场比赛提交

``` json
{
    "status": 0,
    "message": "查询成功",
    "data": {
        "submit_info": [
            {
                "runid": 1,
                "user_id": 1,
                "nick": "123",
                "problem_id": 1001,
                "language": "c++",
                "status": "AC",
                "time": "",
                "memory": "",
                "submit_time": "2019-03-31 13:00:00"
            },
            {
                "runid": 1,
                "user_id": 1,
                "nick": "123",
                "problem_id": 1002,
                "language": "c++",
                "status": "WA",
                "time": "",
                "memory": "",
                "submit_time": "2019-03-31 13:00:00"
            }
        ],
        "penalty": {
            "nick": "123",
            "penalty": -17205167,
            "acnum": 1,
            "problem": {
                "A": {
                    "success_time": -17205167,
                    "times": 0
                },
                "B": {
                    "success_time": "",
                    "times": 1
                }
            }
        }
    }
}
```

* null 得到所有非比赛提交

``` json
{
    "status": 0,
    "message": "查询成功",
    "data": [
        {
            "runid": 1,
            "user_id": 1,
            "nick": "123",
            "problem_id": 123,
            "language": "c++",
            "status": "1",
            "time": "",
            "memory": "",
            "submit_time": "2019-03-31 14:09:47"
        }
    ]
}
```

# feedback

* add_feedback

  *request:*

  ```json
  {
      "content": "wyhsb",
      "img_url": ["url", "url", "url", "url"]//可为空
  }
  ```
  
  *response:*

  ```json
{
      "status": 0,
      "message": "查询成功",
      "data": ""
  }
  ```
  
  

# upload

* upload_image

  *request:*

  ```json
  {
      "image":"file"//文件
  }
  ```

  *response:*

  ```json
  {
      "status": 0,
      "message": "上传成功",
      "data": ""
  }
  ```

  

* upload_avator

  *request:*

  ```json
  {
      "image":"file"//文件
  }
  
  ```

  *response:*

  ```json
  {
      "status": 0,
      "message": "上传成功",
      "data": ""
  }
  ```

* upload_data_file


## Knowledge

#### getAllKnowledge 获取所有知识点

**request: GET**
```json
null
```
**response:**
```json
{
    "status": 0,
    "message": "查询成功",
    "data": [
        {
            "id": 10,
            "name": "force"
        },
        {
            "id": 9,
            "name": "graph"
        },
        {
            "id": 1,
            "name": "tree"
        }
    ]
}
```

#### getKnowledgeByKey 模糊查询知识点

**request: GET**

| param | type| data  |
| ---- | ----| ---- |
| knowledge | string| "e" |


**response:**
```json
{
    "status": 0,
    "message": "查询成功",
    "data": [
        {
            "id": 10,
            "name": "force"
        },
        {
            "id": 1,
            "name": "tree"
        }
    ]
}
```

#### getSpecificKnowledge 精确查询知识点

**request: GET**

| param | type| data  |
| ---- | ----| ---- |
| knowledge | string| "force" |

**response**
```json
{
    "status": 0,
    "message": "查询成功",
    "data": {
        "id": 10,
        "name": "force"
    }
}
```

#### addKnowledge 添加知识点

**request: POST**

| param | type| data  |
| ---- | ----| ---- |
| knowledge | string|"link" |

**response**
```json
{
    "status": 0,
    "message": "插入成功",
    "data": ""
}
```

#### deleteKnowledge 删除知识点

**request: POST**

| param | type| data  |
| ---- | ----| ---- |
| knowledge | string| "link" |

**response:**
```json
{
    "status": 0,
    "message": "删除成功",
    "data": ""
}
```

#### addKnowledgeRelation 添加知识点关系

**request: POST**

|param|type|data|comment|
|----|----|----|----|
|knowledge|string|"force"|知识点|
|pre_knowledge|string|"graph"|前置知识点|
|is_core|int|0|0/１，可为空|

**response:**
```json
{
    "status": 0,
    "message": "插入成功",
    "data": ""
}
```

#### deleteKnowledgeRelation 删除知识点关系

**request: POST**

|param|type|data|comment|
|----|----|----|----|
|knowledge|string|"force"|知识点|
|pre_knowledge|string|"graph"|前置知识点|

**response:**

```json
{
    "status": 0,
    "message": "删除成功",
    "data": ""
}
```

#### getPreKnowledge 获取前置知识点

**request: GET**

|param|type|data|comment|
|----|----|----|----|
|knowledge|string|"force"|知识点|
|core_only|int|0|0/１，可为空|

**response:**
```json
{
    "status": 0,
    "message": "查询成功",
    "data": [
        {
            "id": 1,
            "name": "tree",
            "is_core": 0
        },
        {
            "id": 9,
            "name": "graph",
            "is_core": 0
        }
    ]
}
```


#### getAfterKnowledge 获取后继知识点

**request: GET**

|param|type|data|comment|
|----|----|----|----|
|knowledge|string|"tree"|知识点|
|core_only|int|0|0/１，可为空|

**response:**
```json
{
    "status": 0,
    "message": "查询成功",
    "data": [
        {
            "id": 10,
            "name": "force",
            "is_core": 0
        }
    ]
}
```

#### setKnowledgeRelationCore 设置为必要前置

**request: POST**

|param|type|data|comment|
|----|----|----|----|
|knowledge|string|"force"|知识点|
|pre_knowledge|string|"graph"|前置知识点|

**response:**
```json
{
    "status": 0,
    "message": "更新成功",
    "data": ""
}
```

#### unsetKnowledgeRelationCore 设置为非必要前置

**request: POST**

|param|type|data|comment|
|----|----|----|----|
|knowledge|string|"force"|知识点|
|pre_knowledge|string|"graph"|前置知识点|

**response:**
```json
{
    "status": 0,
    "message": "更新成功",
    "data": ""
}
```

#### getProblemByKnowledge 获取知识点对应问题

**request: GET**

|param|type|data|comment|
|----|----|----|----|
|knowledge|string|"force"|知识点|
|core_only|int|0|0/１，可为空|

**response**
```json
{
    "status": 0,
    "message": "查询成功",
    "data": [
        {
            "problem_id": 1001,
            "is_core": 1
        }
    ]
}
```

#### getKnowledgeByProblem 获取问题对应知识点

**request: GET**

|param|type|data|comment|
|----|----|----|----|
|problem|string|"1001"|问题|
|core_only|int|0|0/１，可为空|

**response:**
```json
{
    "status": 0,
    "message": "查询成功",
    "data": [
        {
            "id": 10,
            "name": "force",
            "is_core": 1
        },
        {
            "id": 1,
            "name": "tree",
            "is_core": 0
        }
    ]
}
```

#### addProblemKnowledgeRelation 添加知识点问题关系

**request: POST**

|param|type|data|comment|
|----|----|----|----|
|knowledge|string|"force"|知识点|
|problem|string|"1002"|问题|
|is_core|int|0|0/１，可为空|

**response:**
```json
{
    "status": 0,
    "message": "插入成功",
    "data": ""
}
```

#### deleteProblemKnowledgeRelation 删除知识点问题关系

**request: POST**

|param|type|data|comment|
|----|----|----|----|
|knowledge|string|"force"|知识点|
|problem|string|"1002"|问题|

**response:**
```json
{
    "status": 0,
    "message": "删除成功",
    "data": ""
}
```

#### setProblemKnowledgeRelationCore 设置知识点问题关系为必要

**request: POST**

|param|type|data|comment|
|----|----|----|----|
|knowledge|string|"force"|知识点|
|problem|string|"1002"|问题|

**response:**
```json
{
    "status": 0,
    "message": "更新成功",
    "data": ""
}
```


#### unsetProblemKnowledgeRelationCore 设置知识点问题关系为不必要

**request: POST**

|param|type|data|comment|
|----|----|----|----|
|knowledge|string|"force"|知识点|
|problem|string|"1002"|问题|

**response:**
```json
{
    "status": 0,
    "message": "更新成功",
    "data": ""
}
```