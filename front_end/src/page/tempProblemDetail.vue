<template>
    <div class="temp-problem-detail">
        <div class="title">{{problem_info.id}} {{problem_info.title}}</div>
        <div class="describe">
            <span class="sub-title">题目描述</span>
            <span class="content">{{problem_info.describe}}</span>
        </div>
        <div class="io-standard">
            <span class="sub-title">输入输出格式</span>
            <span class="content">{{problem_info.io}}</span>
        </div>
        <div class="example-data">
            <span class="sub-title">样例</span>
            <div class="example-data-element" v-for="index in problem_info.example.length">
                <div class="input-example">{{problem_info.example[index-1].input}}</div>
                <div class="output-example">{{problem_info.example[index-1].output}}</div>
            </div>
        </div>
        <div class="hint">
            <span class="sub-title">Hint</span>
            <span class="content">{{problem_info.hint}}</span>
        </div>
        <div class="function-btn-group">
            <button class="submit-btn">Submit</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "temp-problem-detail",
        data() {
            return {
                problem_info: {
                    id: 1000,
                    title: '超级玛丽游戏',
                    describe: '这里是题目描述',
                    io: '这里是输入输出格式描述',
                    example: [
                        {
                            input: '这里是样例输入#1',
                            output: '这里是样例输出#1'
                        },
                        {
                            input: '这里是样例输入#2',
                            output: '这里是样例输出#2'
                        },
                        {
                            input: '这里是样例输入#3',
                            output: '这里是样例输出#3'
                        }
                    ],
                    hint: '这里是hint'
                }
            }
        },
        computed: {
            problem_id: function() {
                return this.$route.params.id;
            },
        }
    }
</script>

<style scoped>
    .temp-problem-detail {
        position: relative;
        background: white;
        top: 88px;
        left: 14px;
        width: 83%;
        margin: 0 auto;
        border-radius: .5em;
        padding: 10px 10px;
    }

    .title {
        display: flex;
        flex-direction: column;
        font-weight: bold;
        font-size: 30px;
    }

    .title::after {
        content: '';
        position: absolute;
        top: 50px;
        height: 1px;
        background: gray;
        width: 70%;
    }

    .sub-title {
        display: block;
        font-weight: bold;
        font-size: 20px;
        margin-top: 12px;
        margin-bottom: 5px;
    }

    .content {
        font-size: 16px;
    }

    .submit-btn {
        -webkit-border-radius: .5em;
        -moz-border-radius: .5em;
        border-radius: .5em;
        font-size: 16px;
        padding: 5px 20px;
        background: #4288ce;
        color: white;
        border: solid 1px #4288ce;
    }

    .submit-btn:hover {

    }
</style>