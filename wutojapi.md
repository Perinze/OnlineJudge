# api

## contest

* getAllContest

*request:*
null

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "查找成功",
    "data": {
        0: {
            "contest_id": 0,
            "contest_name": "wyh女装",
            "begin_time": "2019-11-16 12:30:00",
            "end_time": "2019-11-16 17:30:00",
            "frozen": 0.2,//封榜百分比
            "problems":{
                0: 1000,
                1: 1001,
            },
            "state": 0// 0-有效，1-比赛被禁止
        },
        1: {
            "contest_id": 0,
            "contest_name": "wyh女装",
            "begin_time": "2019-11-16 12:30:00",
            "end_time": "2019-11-16 17:30:00",
            "frozen": 0.2,//封榜百分比
            "problems":{
                0: 1000,
                1: 1001,
            },
            "state": 0// 0-有效，1-比赛被禁止
        }
    }
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
        "problems":{
            0: 1000,
            1: 1001,
        },
        "colors": {
            0: '#eeeeee',
            1: '#aaaaaa'
        },
        "status": 0// 0-有效，1-比赛被禁止
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
    "data": {
        "contest_id": 0,
        "contest_name": "wyh女装",
        "begin_time": "2019-11-16 12:30:00",
        "end_time": "2019-11-16 17:30:00",
        "frozen": 0.2,//封榜百分比
        "problems":{
            0: 1000,
            1: 1001,
        },
        "state": 0// 0-有效，1-比赛被禁止
    }
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
    "problems":{
        0: 1000,
        1: 1001,
    }
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
    "problems":{
        0: 1000,
        1: 1001,
    }
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
    "data": {
        0:{
            "id": 1,
            "title": "wyh女装",
            "link": "",
            "status": 1//1-有效
        }
    }
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
    "data": {
        0:{
            "time": "2019-11-16 00:00:00",
            "ac": 1000,
            "submit": 10000,
        }
    }
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
    "data": ""
}
```

* do_logout

*request:*
null

*response:*
null

* forget_password

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
    "status": 0,//0-success, -1-error
    "message": "操作成功",
    "data": {
        0: {
        "problem_id": 1,
        "title": "wyh女装",
        "ac": 100,
        "wa": 1000,
        "tag": "女装"
        },
        1: {
        "problem_id": 2,
        "title": "wyh女装",
        "ac": 100,
        "wa": 1000,
        "tag": "女装"
        }
    }
}
```

* displayProblem

*request:*

``` json
{
    "problem_id": 1,
}
```

*response:*

``` json
{
    "status": 0,//0-success, -1-error
    "message": "操作成功",
    "data": {
        "problem_id": 1,
        "title": "wyh女装",
        "background": "wyh想要女装了",
        "describe": "描述",
        "input_format": "sxxsasfc",
        "output_format": "ssdds",
        "hint": "",
        "ac": 100,
        "wa": 1000,
        "tag": "女装",
        "status": 1//1-有效
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
    "data": {
        0: {
        "problem_id": 1,
        "title": "wyh女装",
        "ac": 100,
        "wa": 1000,
        "tag": "女装"
        },
        1: {
        "problem_id": 2,
        "title": "wyh女装",
        "ac": 100,
        "wa": 1000,
        "tag": "女装"
        }
    }
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

* submit

## Rank //要更新逻辑

* userRank

* groupRank

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
    "contac": "13132545445",
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

* edituser

* change_password
