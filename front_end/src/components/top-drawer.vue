<template>
    <div id="top-drawer" :style="styleObject">
        <slot class="slot"/>
        <div class="function-group">
            <span>当前题目: {{pid}}</span>
            <span v-if="cid!=null">当前比赛: {{cid}}</span>
            <div>
                <label for="code-lang">编译语言: </label>
                <select v-model="lang" id="code-lang" @change="changeLang">
                    <option
                        v-for="index in langItems.length"
                        :value="langItems[index-1].value"
                        :key="langItems[index-1].value"
                    >
                        {{langItems[index-1].name}}
                    </option>
                </select>
            </div>
        </div>
        <div class="close-btn" @click="close()">
            <img src="../../assets/icon/packup.svg" width="18" height="18" alt="close">
        </div>
    </div>
</template>

<script>
    import { getProblem, submitCode, checkLogin } from "../api/getData";

    export default {
        name: "top-drawer",
        props: [ 'isDisplay', 'pid', 'cid' ],
        data() {
            return {
                lang: 'c.gcc',
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
            close() {
                this.$emit('close');
            },
            changeLang() {
                let index = this.langItems.map(x => x.value).indexOf(this.lang);
                this.$emit('change-lang', this.langItems[index].cmValue);
            },
            doSubmit: async function() {
                // TODO checkLogin
                this.$loading.open();
                let requestData = {
                    language: this.lang,
                    source_code: this.$refs.codeEditor.code,
                    problem_id: this.pid,
                };
                if(this.cid != undefined) {
                    requestData.contest_id = this.cid;
                }
                let response = await submitCode(requestData);
                if(response.status==0) {
                    this.$message({
                        message: '提交成功',
                        type: 'success'
                    });
                    this.$loading.hide();
                    let link = '/status?p='+this.pid+'&s='+response.data;
                    if(this.cid != undefined) {
                        link += '&c=' + this.cid;
                    }
                    this.$router.push(link);
                }else{
                    this.$message({
                        message: '提交失败, 请联系管理员: '+response.message,
                        type: 'error'
                    });
                    this.$loading.hide();
                }
            },
        },
        computed: {
            styleObject() {
                let res = {
                    'margin-top': 0
                };
                if(this.isDisplay) {
                    res['margin-top'] = 0;
                }else{
                    res['margin-top'] = '-95%';
                }
                return res;
            }
        }
    }
</script>

<style lang="scss" scoped>
    #top-drawer {
        position: fixed;
        width: calc((100% - 200px)/2 - 50px);
        height: 95%;
        top: 0;
        left: 220px;
        /*background: rgba(38, 50, 56, 0.65);*/
        background: rgba(255, 255, 255, 0.65);
        border: {
            bottom-left-radius: .8em;
            bottom-right-radius: .8em;
        }
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        z-index: 1001;
        transition: margin-top 0.6s ease-in-out;
    }

    .slot {

    }

    .function-group {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        height: 35px;
        padding: 0 10px;
    }

    .close-btn {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 25px;
        margin-top: 5px;
        /*top: auto;*/
        bottom: 0;
        cursor: pointer;
        /*backdrop-filter: blur(3px);*/
    }
</style>