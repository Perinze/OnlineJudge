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
                            :style="'background: #' + contest_info.colors[index-1]"
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
                <ul>
                    <li v-for="index in submit_log.length"
                        v-bind:title="'RunID: '+ submit_log[index-1].runid"
                        class="submit-log-list-element"
                    >
                        <span>
                            {{submit_log[index-1].submit_time}}
                        </span> <!-- Submit Time -->
                        <span style="font-weight: bold;">
                            {{String.fromCharCode(contest_info.problems.indexOf(submit_log[index-1].problem) + 65)}}
                        </span>
                        <span>
                            {{submit_log[index-1].time_used + 'ms'}}
                        </span> <!-- Time used -->
                        <span>
                            {{submit_log[index-1].mem_used + 'Mb'}}
                        </span> <!-- Memory used -->
                        <span>
                            {{submit_log[index-1].language}}
                        </span> <!-- Language -->
                        <span style="font-weight:bold;"
                              :class="submit_log[index-1].status + '-color'"
                        >
                            {{submit_log[index-1].status.toUpperCase()}}
                        </span> <!-- Result -->
                    </li>
                </ul>
            </div>
            <div class="discuss-list">
                <span class="title">
                    讨论板 Discuss list
                    <i class="see-more"></i>
                </span>
                <!-- TODO 改成卡片样式 -->
                <ol>
                    <li>
                        <div class="discuss-card" v-for="index in discusses.length">
                            <span class="discuss-problem-id">{{String.fromCharCode(contest_info.problems.indexOf(discusses[index-1].problem) + 65)}}</span>
                            <span class="discuss-title">{{discusses[index-1].title}}</span>
                            <span class="discuss-author">{{discusses[index-1].author}}</span>
                        </div>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</template>

<script>
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
                        time_used: 2000, /*毫秒数*/
                        mem_used: 2.54,
                        language: 'cpp',
                        status: 'tle',
                    },
                    {
                        runid: 21063965,
                        problem: 1000,
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
                    {
                        problem: 1001,
                        title: 'title',
                        author: 'author',
                        time: 27
                    },
                    {
                        problem: 1000,
                        title: 'title',
                        author: 'author',
                        time: 27
                    },
                    {
                        problem: 1001,
                        title: 'title',
                        author: 'author',
                        time: 27
                    },
                ]
            }
        }
    }
</script>

<style scoped>
    ul, ol {
        position: relative;
        list-style-type: none;
        padding-left: 5px;
        margin-top: 10px;
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
        /*border: 1px solid #333333;*/
        text-align: center;
    }

    .problem-head {
        cursor: pointer;
        /*
            TODO 点击后弹出题目
        */
    }

    .problem-status {
        cursor: pointer;
        /*
            TODO 点击后在提交列表内相应题目记录高亮，再次点击消除
        */
    }

    .see-more {
        cursor: pointer;
    }

    .submit-log-list {
        width: 47%;
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
        height: 130px;
        border-radius: .5em;
        box-shadow: 0 5px 10px rgba(0,0,0,0.3);
        z-index: 1;
        overflow: hidden;
        margin-bottom: 20px;
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
        top: 95px;
    }

    /*th {*/
        /*background: yellow;*/
    /*}*/

    /*td {*/
        /*background: red;*/
    /*}*/
</style>