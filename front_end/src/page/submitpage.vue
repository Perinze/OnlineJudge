<template>
    <div class="submit">
        <div class="submit-head">
            <div class="problem-title">{{$route.params.pid}} {{title}}</div>
            <button class="submit-btn" @click="doSubmit">Submit</button>
        </div>
        <div class="code-container">
            <!--<label for="codeEditor">代码输入框:</label>-->
            <div class="tips">
                <span>第一版CodeEditor, 功能尚不完整, 请使用本地IDE编辑代码后复制粘贴于此提交</span>
                <div>
                    <label for="code-lang">选择编译语言: </label>
                    <select v-model="lang" id="code-lang">
                        <option
                                v-for="index in langItems.length"
                                :value="langItems[index-1].value"
                        >
                            {{langItems[index-1].name}}
                        </option>
                    </select>
                </div>
            </div>
            <mycodemirror id="codeEditor" :lang="getCMLang" ref="codeEditor"/>
        </div>
    </div>
</template>

<script>
    import mycodemirror from '../components/myCodemirror';
    import { getProblem, submitCode } from "../api/getData";

    export default {
        name: "submitpage",
        components: {
            mycodemirror
        },
        data() {
            return {
                title: '',
                lang: 'c.gcc',
                code: '',
                langItems: [
                    {
                        name: 'C',
                        value: 'c.gcc',
                        cmValue: 'text/x-csrc'
                    },
                    {
                        name: 'C++11',
                        value: 'cpp.g++',
                        cmValue: 'text/x-c++src'
                    },
                    // {
                    //     name: 'Java',
                    //     value: 'java',
                    //     cmValue: 'text/x-java'
                    // },
                    // {
                    //     name: 'Python3.6',
                    //     value: 'python',
                    //     cmValue: 'python'
                    // },
                ]
            }
        },
        methods: {
            getProblemInfo: async function() {
                let response = await getProblem({
                    problem_id: this.$route.params.pid
                });
                if(response.status == 0) {
                    this.title = response.data.title;
                }
            },
            doSubmit: async function() {
                this.$loading.open();
                console.log({
                    language: this.lang,
                    source_code: this.$refs.codeEditor.code,
                    problem_id: this.$route.params.id,
                    // contest_id:
                });
                let response = await submitCode({
                    language: this.lang,
                    source_code: this.$refs.codeEditor.code,
                    problem_id: this.$route.params.pid,
                    // contest_id:
                });
                console.log(response);
                if(response.status==0) {
                    this.$message({
                        message: '提交成功',
                        type: 'success'
                    });
                    this.$loading.hide();
                    this.$router.push('/status/'+this.$route.params.pid+'/'+(response.data.id===undefined?'1':response.data.id));
                }else{
                    this.$message({
                        message: '提交失败, 请联系管理员: '+response.message,
                        type: 'error'
                    });
                    this.$loading.hide();
                }
            }
        },
        computed: {
            getCMLang() {
                let res = this.langItems.map(function(e) {return e.value}).indexOf(this.lang);
                if(res===-1) {
                    return "text/x-csrc";
                }else{
                    return this.langItems[res].cmValue;
                }
            },
        },
        created() {
            this.getProblemInfo();
        }
    }
</script>

<style lang="scss" scoped>
    .submit {
        position: relative;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        overflow-y: scroll;
        padding-left: 27px;
        > :first-child {
            margin-top: 88px;
        }
        display: flex;
        flex-direction: column;
        align-items: center;
        &-head {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            width: 80%;
            padding-right: 1px;
            margin-bottom: 10px;
        }
    }

    .submit-btn {
        background: none;
        border: 1px solid #4288ce;
        border-radius: 10px;
        color: #4288ce;
        width: 80px;
        cursor: pointer;
        &:hover {
            text-decoration: underline;
        }
    }

    .problem-title {
        font: {
            size: 20px;
            weight: bold;
        }
    }

    .code-container {
        width: 80%;
        margin: 0 auto;
        height: 500px;
        .tips {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            > span, label {
                display: inline-block;
                color: red;
                font: {
                    size: 12px;
                }
            }
            > div > select {
                appearance: none;
                background: url("../../assets/icon/arrow-bottom.svg") no-repeat scroll right center transparent;
                background-size: 14px 14px;
                margin-right: 1px;
                margin-left: 5px;
                border: 1px solid gray;
                border-radius: .2em;
                padding: 0 15px 0 7px;
            }
        }
        #codeEditor {
            border-radius: .3em;
            overflow: hidden;
        }
    }
</style>