<template>
    <div class="problem-detail-container">
        <div class="temp-problem-detail">
            <div class="title">{{problem_info.id}} {{problem_info.title}}</div>
            <div class="problem-background">
                <span class="sub-title">题目背景</span>
                <span class="content">{{problem_info.background}}</span>
            </div>
            <div class="describe">
                <span class="sub-title">题目描述</span>
                <span class="content">{{problem_info.describe}}</span>
            </div>
            <div class="io-standard">
                <span class="sub-title">输入格式</span>
                <span class="content">{{problem_info.input_sample}}</span>
            </div>
            <div class="io-standard">
                <span class="sub-title">输出格式</span>
                <span class="content">{{problem_info.output_sample}}</span>
            </div>
            <div class="example-data">
                <span class="sub-title">样例</span>
                <div class="example-data-element" v-for="index in problem_info.example.length">
                    <div class="input-example sub-example">{{problem_info.example[index-1].input}}</div>
                    <div class="output-example sub-example">{{problem_info.example[index-1].output}}</div>
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
    </div>
</template>

<script>
    import { getProblem } from "../api/getData";

    export default {
        name: "temp-problem-detail",
        data() {
            return {
                problem_info: {
                    id: this.$route.params.id,
                    title: '超级玛丽游戏',
                    background: '这里是题目背景',
                    describe: '这里是题目描述',
                    input_sample: '这里是输入格式描述',
                    output_sample: '这里是输出格式描述',
                    example: [
                        // {
                        //     input: '这里是样例输入#1',
                        //     output: '这里是样例输出#1'
                        // },
                        // {
                        //     input: '这里是样例输入#2',
                        //     output: '这里是样例输出#2'
                        // },
                        // {
                        //     input: '这里是样例输入#3',
                        //     output: '这里是样例输出#3'
                        // }
                    ],
                    hint: '这里是hint'
                }
            }
        },
        async mounted() {
            this.renderProblemDetail();
        },
        methods: {
            renderProblemDetail: async function() {
                let response = await getProblem({
                    problem_id: this.$route.params.id
                });
                if(response.status == 0) {
                    let data = response.data;
                    this.problem_info.title = data.title;
                    this.problem_info.background = data.background;
                    this.problem_info.describe = data.describe;
                    this.problem_info.input_sample = data.input_format;
                    this.problem_info.output_sample = data.output_format;
                    this.problem_info.hint = data.hint;
                    data.sample.forEach( (val, index) => {
                    	this.problem_info.example.push(val);
                    });
                }else{

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
    .problem-detail-container {
    }

    .temp-problem-detail {
        position: relative;
        background: white;
        top: 88px;
        left: 14px;
        width: 83%;
        margin: 0 auto 80px auto;
        border-radius: .5em;
        padding: 20px 20px;
    }

    .title {
        display: flex;
        flex-direction: column;
        font-weight: bold;
        font-size: 32px;
    }

    .title::after {
        content: '';
        position: absolute;
        top: 65px;
        height: 1px;
        background: gray;
        width: 70%;
    }

    .sub-title {
        display: block;
        font-weight: bold;
        font-size: 21px;
        margin-top: 12px;
        margin-bottom: 5px;
    }

    .content {
        font-size: 17px;
    }

    .submit-btn {
        margin-top: 25px;
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
        text-decoration: underline;
    }

    .example-data-element {
        width: 53%;
        display: flex;
        justify-content: space-between;
        margin: 20px 0;
    }

    .sub-example {
        background: #eeeeee;
        border: 1px solid #aaaaaa;
        border-radius: .4em;
        padding: 10px 25px;
    }

    .function-btn-group {
        display: flex;
        justify-content: flex-end;
        padding: 0 20px 10px 20px;
    }
</style>