<template>
    <div class="contestpage">
        <div class="top">
            <label class="tips">点击题号查看题面 Please click problem label to see the detail</label>
            <table class="problem-status-form"
                   cellspacing="10"
                   cellpadding="12"
                   width="100%"
            >
                <thead>
                    <tr style="height: 42px;">
                        <th>排名 Rank</th>
                        <th>罚时 Penalty</th>
                        <th v-for="index in contest_info.problems.length"
                            class="problem-head"
                        >
                            {{String.fromCharCode(64 + index)}}
                        </th>
                    </tr>
                </thead>
                <tr style="height: 42px;">
                    <td>
                        1
                    </td>
                    <td>
                        1000
                    </td>
                    <td v-for="index in contest_info.problems.length" class="problem-status">

                    </td>
                </tr>
            </table>
            <div class="function-btn-group">

            </div>
        </div>
        <div class="bottom">
            <div class="submit-log-list">
                <span class="title">提交记录 Submit log</span>
                <span id="submit-log-tips" class="tips">点击查看具体记录</span>
                <ul class="submit-log-ul">
                    <li v-for="index in submit_log.length"
                        v-bind:title="'RunID: '+ submit_log[index-1].runid"
                        class="submit-log-list-element submit-log-li"
                    >
                        <i :style="{background: 'radial-gradient(circle, rgba(255,255,255,0) 36%, #' + contest_info.colors[contest_info.problems.indexOf(submit_log[index-1].problem)] + ' 40%)'}"></i>
                        <div>
                            <span style="display: block;">
                                {{contestBeginTime + 1000*submit_log[index-1].submit_time | formatDate}}
                            </span> <!-- Submit Time -->
                            <span style="font-weight: bold;" class="log-problem-id">
                                {{String.fromCharCode(contest_info.problems.indexOf(submit_log[index-1].problem) + 65)}}
                            </span>
                            <span class="log-time-used">
                                {{submit_log[index-1].time_used + 'ms'}}
                            </span> <!-- Time used -->
                            <span class="log-mem-used">
                                {{submit_log[index-1].mem_used + 'Mb'}}
                            </span> <!-- Memory used -->
                            <span class="log-language">
                                {{submit_log[index-1].language}}
                            </span> <!-- Language -->
                            <span style="font-weight:bold;" :class="submit_log[index-1].status + '-color'" class="log-status">
                                {{submit_log[index-1].status.toUpperCase()}}
                            </span> <!-- Result -->
                        </div>
                    </li>
                </ul>
            </div>
            <div class="discuss-list">
                <span class="title">
                    讨论板 Discuss list
                    <span class="see-more tips">点我查看更多, 提问问题</span>
                </span>
                <!-- TODO 改成卡片样式 -->
                <ol>
                    <li>
                        <div class="discuss-card" v-for="index in discusses.length">
                            <span class="discuss-problem-id">
                                {{String.fromCharCode(contest_info.problems.indexOf(discusses[index-1].problem) + 65)}}
                            </span>
                            <span class="discuss-title">
                                {{discusses[index-1].title}}
                            </span>
                            <span class="discuss-author">
                                {{discusses[index-1].author}}
                            </span>
                        </div>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</template>

<script>
    import { formatDate } from "../api/common";

    export default {
        name: "contestpage",
        data() {
            return {
                contest_info: {
                    begin_time: '2019-09-23 10:46:57', /*比赛开始时间*/
                    end_time: '2019-09-23 15:46:57',
                    frozen: true,
                    problems: [1000,1001,1002,1003,1004,1005,1006,1007,1008,1009,1010,1011,1012],
                    colors: ['924726','8cc590','b2c959','59785a','8e8c13','252b04','ccda06','8044a7','27e298','0cef7c','31f335','67f70e','0ea6ff'],
                },
                submit_log: [
                    {
                        runid: 21063965,
                        problem: 1000,
                        submit_time: 12, /* 比赛开始后的秒数*/
                        time_used: 234, /*毫秒数*/
                        mem_used: 2.54,
                        language: 'cpp',
                        status: 'ac',
                    },
                    {
                        runid: 21063965,
                        problem: 1000,
                        submit_time: 12, /* 比赛开始后的秒数*/
                        time_used: 234, /*毫秒数*/
                        mem_used: 2.54,
                        language: 'cpp',
                        status: 'wa',
                    },
                    {
                        runid: 21063965,
                        problem: 1005,
                        submit_time: 12, /* 比赛开始后的秒数*/
                        time_used: 2000, /*毫秒数*/
                        mem_used: 2.54,
                        language: 'cpp',
                        status: 'tle',
                    },
                    {
                        runid: 21063965,
                        problem: 1010,
                        submit_time: 12, /* 比赛开始后的秒数*/
                        time_used: 2, /*毫秒数*/
                        mem_used: 2.54,
                        language: 'cpp',
                        status: 'wa',
                    },
                    {
                        runid: 21063965,
                        problem: 1000,
                        submit_time: 12, /* 比赛开始后的秒数*/
                        time_used: 234, /*毫秒数*/
                        mem_used: 2.54,
                        language: 'cpp',
                        status: 'ac',
                    },
                    {
                        runid: 21063965,
                        problem: 1000,
                        submit_time: 12, /* 比赛开始后的秒数*/
                        time_used: 234, /*毫秒数*/
                        mem_used: 2.54,
                        language: 'cpp',
                        status: 'wa',
                    },
                    {
                        runid: 21063965,
                        problem: 1005,
                        submit_time: 12, /* 比赛开始后的秒数*/
                        time_used: 2000, /*毫秒数*/
                        mem_used: 2.54,
                        language: 'cpp',
                        status: 'tle',
                    },
                    {
                        runid: 21063965,
                        problem: 1010,
                        submit_time: 12, /* 比赛开始后的秒数*/
                        time_used: 2, /*毫秒数*/
                        mem_used: 2.54,
                        language: 'cpp',
                        status: 'wa',
                    },
                ],
                discusses: [
                    {
                        problem: 1001,
                        title: 'title',
                        author: 'author',
                        time: 23
                    },
                    {
                        problem: 1001,
                        title: 'title',
                        author: 'author',
                        time: 27
                    },
                    {
                        problem: 1005,
                        title: 'title',
                        author: 'author',
                        time: 27
                    },
                ]
            }
        },
        computed: {
            contestBeginTime: function() {
                var res = new Date(this.contest_info.begin_time).getTime();
                return res;
            }
        },
        filters: {
            formatDate(time) {
                var date = new Date(time);
                return formatDate(date, 'yyyy-MM-dd hh:mm:ss')
            }
        }
    }
</script>

<style scoped>
    ul, ol {
        position: relative;
        list-style-type: none;
        padding-left: 5px;
        margin-top: 15px;
    }

    li {
        cursor: pointer;
    }

    li > span {
        margin: 0 5px;
    }

    .tips {
        font-size: 12px;
        font-weight: bold;
        float: right;
    }

    .contestpage {
        position: relative;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        overflow-y: scroll;
    }

    .top {
        width: 80%;
        max-width: 990px;
        margin: 88px auto 0 auto;
    }

    .bottom {
        display: flex;
        width: 80%;
        max-width: 990px;
        margin: 30px auto 0 auto;
        justify-content: space-between;
    }

    .problem-status-form {
        text-align: center;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        background: white;
    }

    .problem-head {
        cursor: pointer;
        border-left: 1px rgba(0,0,0,.2) dashed;
        /*
            TODO 点击后弹出题目
        */
    }

    .problem-status {
        cursor: pointer;
        border-left: 1px rgba(0,0,0,.2) dashed;
        /*
            TODO 点击后在提交列表内相应题目记录高亮，再次点击消除
        */
    }

    .see-more {
        cursor: pointer;
        margin-top: 5px;
    }

    .submit-log-list {
        width: 47%;
    }

    .submit-log-ul {
        padding-left: 0;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        overflow: hidden;
        background: white;
    }

    .submit-log-li:last-child {
        border: none;
    }

    .submit-log-li {
        height: 50px;
        border-bottom: 1px solid rgb(0,0,0,.1);
        display: flex;
        align-items: center;
    }

    .submit-log-li > i {
        content: '';
        position: absolute;
        height: 16px;
        width: 16px;
        border-radius: 10px;
        margin-left: 11px;
        filter: brightness(130%);
    }

    .submit-log-li > div {
        margin-left: 35px;
    }

    #submit-log-tips {
        margin-top: 5px;
        margin-right: 4px;
    }

    .discuss-list {
        width: 40%;
    }

    .title {
        padding-left: 5px;
        font-weight: bold;
        font-size: 16px;
    }

    .function-btn-group {

    }

    .submit-log-list-element {
        /*background: linear-gradient(360deg, rgba(100,26,56,.7) 3%, rgba(255,255,255,0)),*/
                    /*linear-gradient(90deg, rgba(255,255,255,0) 100%, rgba(255,255,255,0));*/
    }

    .discuss-card {
        height: 110px;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        z-index: 1;
        overflow: hidden;
        margin-bottom: 20px;
        background: white;
    }

    /*.discuss-card::after {*/
        /*content: '';*/
        /*position: absolute;*/
        /*left: 0;*/
        /*right: 0;*/
        /*top: 0;*/
        /*bottom: 0;*/
        /*background: white;*/
        /*filter: blur(10px) opacity(0.5);*/
        /*z-index: -1;*/
    /*}*/

    .discuss-problem-id {
        position: relative;
        top: 5px;
        left: 10px;
        font-size: 20px;
    }

    .discuss-title {
        position: relative;
        top: 25px;
        left: 20px;
    }

    .discuss-author {
        position: relative;
        left: 75%;
        top: 75px;
    }

    /*th {*/
        /*background: yellow;*/
    /*}*/

    /*td {*/
        /*background: red;*/
    /*}*/
</style>