<template>
    <div class="submit-detail">
        <div class="content">
            <div class="content-head">
                <div>{{$route.params.pid}} {{title}}</div>
                <div class="status-icon">{{getErrorName(status.toLowerCase())}}</div>
            </div>
            <div class="content-statistic">
                <div>
                    Language: {{lang}}
                </div>
                <div>
                    Time: {{timeUsed | timeUsedFormat}}
                </div>
                <div>
                    Memory: {{memoryUsed | memoryUsedFormat}}
                </div>
                <div>
                    SubmitTime: {{submitTime}}
                </div>
            </div>
            <div class="content-code">
                <mycodemirror :lang="cmlang" :readOnly="true" :precode="code"/>
            </div>
        </div>
    </div>
</template>

<script>
    import { getWholeErrorName } from "../api/common";
    import { getProblem } from "../api/getData";
    import Mycodemirror from "../components/myCodemirror";

    export default {
        components: {Mycodemirror},
        name: "submitdetail",
        data() {
            return {
                title: '',
                status: 'Judging',
                lang: 'C',
                code: '#include <iostream>\nusing namespace std;\nint main() {\n\treturn 0;\n}\n',
                memoryUsed: 262144,
                timeUsed: 1259320,
                submitTime: '2019-10-28 10:20:45'
            }
        },
        computed: {
            cmlang() {
                switch(this.lang.toLowerCase()) {
                    case 'c': return 'text/x-csrc';
                    case 'c++': return 'text/x-c++src';
                    case 'java': return 'text/x-java';
                    case 'python': return 'python';
                    default: return 'text/x-csrc';
                }
            }
        },
        filters: {
            timeUsedFormat: function(val) {
                let res = parseInt(val); // ns
                res/=1000000; // ms
                return parseInt(res)+" ms";
            },
            memoryUsedFormat: function(val) {
                let res = parseInt(val); // byte
                res/=1024.0*1024.0;
                if(res<=0.01) {
                    res*=1024;
                    res = res.toFixed(2);
                    return res + " Kb";
                }
                res = res.toFixed(2);
                return res + " Mb";
            }
        },
        created() {
            // this.renderStatus();
            this.renderProblemInfo();
        },
        methods: {
            getErrorName(status) {
                return getWholeErrorName(status);
            },
            renderProblemInfo: async function() {
                let response = await getProblem({
                    problem_id: this.$route.params.pid
                });
                if(response.status==0){
                    this.title = response.data.title;
                }else{
                    this.$message({
                        message: '发生错误: ' + response.message + ', 请联系管理员',
                        type: 'error'
                    })
                }
            },
            renderStatus: async function() {
                // let response = await ({
                //    id: this.$route.params.sid,
                // })
                console.log(response);
                if(response.status==0) {

                }else{

                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .submit-detail {
        position: relative;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        overflow-y: scroll;
        padding-left: 27px;
        > :first-child {
            margin-top: 88px;
        }
    }

    .content {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 80px;
        > div {
            width: 80%;
        }
        &-head {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            font: {
                weight: bold;
                size: 20px;
            }
        }
        &-statistic {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }
        &-code {
            margin-top: 10px;
        }
    }

    .status-icon {
        padding: 2px 15px;
        text-align: center;
        font: {
            size: 17px;
            weight: normal;
        }
        border: {
            width: 1px;
            style: solid;
            color: gray;
            radius: .5em;
        }
    }
</style>