<template>
    <div id="main" class="contestpage">
        <div id="canvas" class="mask" v-if="!isBegin">
            <div class="mask-background"></div>
            <div class="last-time">{{leftBeforeBegin}}</div>
        </div>
        <div class="top">
            <div class="top-tips">
                <label class="countdown-label">
                    <span id="time-before-end">距离比赛结束还有: {{ leftTime }}</span>
                    <span id="frozen" v-if="isFrozen">&nbsp;&nbsp;已经封榜</span>
                </label>
                <label class="tips">点击题号查看题面 Please click problem label to see the detail</label>
            </div>
            <table class="problem-status-form"
                   cellspacing="10"
                   cellpadding="12"
                   width="100%"
            >
                <thead>
                    <tr style="height: 42px;">
                        <th class="status-rank" @click="$router.push('/rank/' + contest_info.id)">排名 Rank</th>
                        <th>罚时 Penalty</th>
                        <th v-for="index in contest_info.problems.length"
                            class="problem-head"
                            @click="$router.push('/problem/'+contest_info.problems[index-1])"
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
                    <td v-for="index in contest_info.problems.length"
                        class="problem-status"
                    >
                        <status-icon :is-success="true" times="12" />
                    </td>
                </tr>
            </table>
            <div class="function-btn-group">

            </div>
        </div>
        <div class="bottom">
            <div class="submit-log-list">
                <span class="title">提交记录 Submit log</span>
                <!-- TODO 暂时取消查看代码 -->
                <!--<span id="submit-log-tips" class="tips">点击查看具体记录</span>-->
                <ul class="submit-log-ul">
                    <li v-for="index in submit_log.length"
                        v-bind:title="'RunID: '+ submit_log[index-1].runid"
                        class="submit-log-list-element submit-log-li"
                    >
                        <!--<i :style="{background: 'radial-gradient(circle, rgba(255,255,255,0) 36%, #' + contest_info.colors[contest_info.problems.indexOf(submit_log[index-1].problem)] + ' 40%)'}"></i>-->
                        <div class="log-element">
                            <div class="log-element-left">
                                <div class="log-element-left-top">
                                    <span style="font-weight: bold;" class="log-problem-id">
                                        {{String.fromCharCode(contest_info.problems.indexOf(submit_log[index-1].problem) + 66)}}
                                    </span>
                                    <span style="font-weight:bold;" :class="submit_log[index-1].status + '-color'" class="log-status">
                                        {{getErrorName(submit_log[index-1].status)}}
                                    </span> <!-- Result -->
                                </div>
                                <div class="log-element-left-bottom">
                                    <span>
                                        {{contestBeginTime + 1000*submit_log[index-1].submit_time | formatDate}}
                                    </span> <!-- Submit Time -->
                                </div>
                            </div>
                            <div class="log-element-right">
                                <span class="log-time-used">
                                    {{submit_log[index-1].time_used + 'ms'}}
                                </span> <!-- Time used -->
                                <span class="log-mem-used">
                                    {{submit_log[index-1].mem_used + 'Mb'}}
                                </span> <!-- Memory used -->
                                <span class="log-language">
                                    {{submit_log[index-1].language}}
                                </span> <!-- Language -->
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="discuss-list">
                <span class="title">
                    讨论板 Discuss list
                    <span class="see-more tips" @click="$router.push('/discuss/'+contest_info.id)">点我查看更多, 提问问题</span>
                </span>
                <!-- TODO 改成卡片样式 -->
                <ol>
                    <li>
                        <div class="discuss-card" v-for="index in discusses.length">
                            <span class="discuss-problem-id">
                                {{String.fromCharCode(contest_info.problems.indexOf(discusses[index-1].problem) + 66)}}
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
    import { getWholeErrorName, logoutWork } from "../api/common";
    import StatusIcon from "../components/status-icon";
    import { getContest, getSubmitInfo } from "../api/getData";

    export default {
        components: {StatusIcon},
        name: "contestpage",
        data() {
            return {
                contest_info: {
                    id: this.$route.params.id,
                    title: '',
                    begin_time: '2019-09-29 09:57:30', /*比赛开始时间*/
                    end_time: '2019-09-29 15:46:57',
                    frozen: 0.2,
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
                ],
                leftBeforeBegin: '00:00:00',
                leftTime: '00:00:00',
            }
        },
        computed: {
            contestBeginTime: function() {
                let res = new Date(this.contest_info.begin_time).getTime();
                return res;
            },
            isBegin: function() {
                let begin = new Date(this.contest_info.begin_time).getTime();
                let now = new Date().getTime();
                if (now >= begin) return true;
                return false;
            },
            isFrozen: function() {
                return true;
            }
        },
        filters: {
            formatDate(time) {
                let date = new Date(time);
                return formatDate(date, 'yyyy.MM.dd hh:mm:ss')
            }
        },
        created() {
            this.countDownToBegin();
            this.countDownToEnd();
            this.renderStatusList();
            this.renderContestInfo();
        },
        methods: {
            timeFormat(param) {
                return param < 10 ? '0' + param : param;
            },
            countDownToBegin() {
                var interval = setInterval(() => {
                    // 获取当前时间，同时得到活动结束时间数组
                    let newTime = new Date().getTime();
                    // 对结束时间进行处理渲染到页面
                    let beginTime = new Date(this.contest_info.begin_time).getTime();
                    let obj = null;
                    // 如果活动未结束，对时间进行处理
                    if (beginTime - newTime > 0) {
                        let time = (beginTime - newTime) / 1000;
                        // 获取天、时、分、秒
                        let hou = parseInt(time % (60 * 60 * 24) / 3600);
                        let min = parseInt(time % (60 * 60 * 24) % 3600 / 60);
                        let sec = parseInt(time % (60 * 60 * 24) % 3600 % 60);
                        obj = {
                            hou: this.timeFormat(hou),
                            min: this.timeFormat(min),
                            sec: this.timeFormat(sec)
                        };
                    } else { // 活动已结束，全部设置为'00'
                        obj = {
                            hou: '00',
                            min: '00',
                            sec: '00'
                        };
                        clearInterval(interval);
                    }
                    this.leftBeforeBegin =  obj.hou + ':' + obj.min + ':' + obj.sec;
                }, 1000);
            },
            countDownToEnd() {
                var interval = setInterval(() => {
                    // 获取当前时间，同时得到活动结束时间数组
                    let newTime = new Date().getTime();
                    // 对结束时间进行处理渲染到页面
                    let beginTime = new Date(this.contest_info.begin_time).getTime();
                    let endTime = new Date(this.contest_info.end_time).getTime();
                    let obj = obj = {
                        hou: '05',
                        min: '00',
                        sec: '00'
                    };
                    // 活动开始后才倒计时
                    if(beginTime < newTime) {
                        // 如果活动未结束，对时间进行处理
                        if (endTime - newTime > 0) {
                            let time = (endTime - newTime) / 1000;
                            // 获取天、时、分、秒
                            let hou = parseInt(time % (60 * 60 * 24) / 3600);
                            let min = parseInt(time % (60 * 60 * 24) % 3600 / 60);
                            let sec = parseInt(time % (60 * 60 * 24) % 3600 % 60);
                            obj = {
                                hou: this.timeFormat(hou),
                                min: this.timeFormat(min),
                                sec: this.timeFormat(sec)
                            };
                        } else { // 活动已结束，全部设置为'00'
                            obj = {
                                hou: '00',
                                min: '00',
                                sec: '00'
                            };
                            clearInterval(interval);
                        }
                    }
                    this.leftTime =  obj.hou + ':' + obj.min + ':' + obj.sec;
                }, 1000);
            },
            getErrorName(status) {
                return getWholeErrorName(status);
            },
            renderContestInfo: async function() {
                let response = await getContest({
                    contest_id: this.$route.params.id
                });
                if(response.status == 0) {
                    let data = response.data;
                    this.contest_info.title = data.contest_name;
                    this.contest_info.begin_time = data.begin_time;
                    this.contest_info.end_time = data.end_time;
                    this.contest_info.frozen = data.frozen;
                    this.contest_info.problems = data.problems;
                    this.contest_info.colors = data.colors;
                }else{

                }
            },
            renderStatusList: async function() {
                let response = await getSubmitInfo({
                    contest_id: this.$route.params.id,
                    // 保证传回来的是自己相关的状态（本页面的业务需求）
                    user_id: localStorage.getItem('userId')
                });
                if(response.status == 0) {
                    response.data.penalty.problem.forEach( (val, index) => {

                    });
                    response.data['submit_info'].forEach( (val, index) => {

                    });
                }else{
                    if(response.status === 504) {
                        // timeout
                    }else{
                        if(response.message == "未登录") {
                            logoutWork();
                            this.$router.go(-1);
                            this.$message({
                                message: '登陆状态过期，请重新登录',
                                type: 'error'
                            });
                        }else{

                        }
                    }
                }
                // console.log(response);
            }
        }
    }
</script>

<style lang="scss" scoped>
    ul, ol {
        position: relative;
        list-style-type: none;
        padding-left: 5px;
        margin-top: 15px;
    }

    li {
        cursor: pointer;
        > span {
            margin: 0 5px;
        }
    }

    .top-tips {
        display: flex;
        justify-content: space-between;
        margin-bottom: 3px;
    }

    .tips {
        font: {
            size: 12px;
            weight: bold;
        }
        float: right;
    }

    .countdown-label {
        display: inline-block;
        font: {
            size: 12px;
            weight: bold;
        }
        height: 18px;
    }

    /* 布局 */

    .contestpage {
        position: relative;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        overflow-y: scroll;
    }

    /* 开赛前毛玻璃波纹效果 */

    .mask {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        overflow: hidden;
        z-index: 999;
        &-background {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            overflow: hidden;
            filter: blur(3px) opacity(80%);
            background: white;
            z-index: 1;
        }
    }

    .last-time {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        padding-bottom: 6%;
        display: flex;
        align-items: center;
        justify-content: center;
        font: {
            size: 120px;
            family: countdown;
        }
        z-index: 1000;
        /*width:*/
    }

    /* 毛玻璃波纹 END */

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
        &:hover {
            text-decoration: underline;
        }
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

    .status-rank {
        color: #338bb8;
        cursor: pointer;
        &:hover {
            color: #5c8db7;
            text-decoration: underline;
        }
    }

    .see-more {
        cursor: pointer;
        margin-top: 5px;
        &:hover {
            text-decoration: underline;
        }
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

    .submit-log-li {
        // TODO 暂时取消查看代码
        cursor: unset;
        height: 50px;
        border-bottom: 1px solid rgba(0,0,0,.1);
        display: flex;
        align-items: center;
        &:last-child {
            border: none;
        }
        > i {
            content: '';
            position: absolute;
            height: 16px;
            width: 16px;
            border-radius: 10px;
            margin-left: 11px;
            filter: brightness(130%);
        }
        > div {
            margin-left: 35px;
        }
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

    .log-element {
        display: flex;
        flex-direction: row;
        width: 100%;
        margin-top: -4px;
        &-left {
            display: flex;
            flex-direction: column;
            width: 40%;
            &-bottom {
                font-size: 10px;
                height: 13px;
            }
        }
        &-right {
            display: flex;
            flex-direction: row;
            align-items: flex-end;
            justify-content: space-between;
            width: 40%;
        }
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
</style>