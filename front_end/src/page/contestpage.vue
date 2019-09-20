<template>
    <div class="contestpage">
        <div class="top">
            <table class="problem-status-form"
                   cellpadding="12px"
                   width="100%"
                   rules="all"
            >
                <thead>
                    <tr style="height: 42px;">
                        <th>排名 Rank</th>
                        <th>罚时 Penalty</th>
                        <th v-for="index in 10" class="problem-head">{{String.fromCharCode(64 + index)}}</th>
                    </tr>
                </thead>
                <tr style="height: 42px;">
                    <td>
                        1
                    </td>
                    <td>
                        1000
                    </td>
                    <td v-for="index in 10">

                    </td>
                </tr>
            </table>
            <div class="function-btn-group">
                <button></button>
            </div>
        </div>
        <div class="bottom">
            <div class="submit-log-list">
                <span class="title">提交记录 Submit log</span>
                <ul>
                    <li v-for="index in 12">
                        <!-- TODO <span>RunID</span> 改为鼠标悬停tips -->
                        <span>A</span>
                        <span>Result</span>
                        <span>Time</span>
                        <span>Memory</span>
                        <!--<span>Length</span>-->
                        <span>Lang</span>
                        <span>SubmitTime</span>
                    </li>
                </ul>
            </div>
            <div class="discuss-list">
                <span class="title">
                    讨论板 Discuss list
                    <i class="see-more"></i>
                </span>
                <ul>
                    <li>
                        <span>A</span>
                        <span>Title</span>
                        <span>Author</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "contestpage"
    }
</script>

<style scoped>
    ul {
        list-style-type: none;
    }

    li {
        cursor: pointer;
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
        border: 1px solid #333333;
        text-align: center;
    }

    .problem-head {
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
</style>