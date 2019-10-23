<template>
    <div class="discuss-detail">
        <ul class="discuss-content">
            <li class="content-head">
                <div class="head-title">{{themeInfo.problem_id}}  {{themeInfo.title}}</div>
                <div class="head-content">{{themeInfo.content}}</div>
                <div class="head-user">{{themeInfo.user_id}}</div>
                <div class="head-time">{{themeInfo.time}}</div>
            </li>
            <li class="content-element"
                v-for="index in replyItems.length"
            >
                <div class="element-content">{{replyItems[index-1].content}}</div>
                <div class="element-user">{{replyItems[index-1].user_id}}</div>
                <div class="element-time">{{replyItems[index-1].time}}</div>
            </li>
        </ul>
        <div class="reply-input-group">
            <textarea placeholder="在此填入回复内容(至少10个字符)..." v-model="replyContent"></textarea>
            <button class="submit-reply-btn" @click="do_addReply">Reply</button>
        </div>
    </div>
</template>

<script>
    import { getDiscussDetail, addReply } from "../api/getData";

    export default {
        name: "discussdetail",
        data() {
            return {
                themeInfo: {
                    id: '',
                    contest_id: '',
                    problem_id: '',
                    user_id: '',
                    title: '',
                    content: '',
                    time: '',
                    status: '',
                },
                replyItems: [
                    // {
                    //     id: '',
                    //     discuss_id: '',
                    //     user_id: '',
                    //     content: '',
                    //     time: ''
                    // },
                ],
                replyContent: ''
            }
        },
        beforeMount() {
            this.renderContent();
        },
        methods: {
            renderContent: async function() {
                this.$loading.open();
                let response = await getDiscussDetail({
                    discuss_id: this.$route.params.did
                });
                console.log(response);
                if(response.status == 0) {
                    this.themeInfo = response.data[0];
                    response.data[1].forEach( (val, index) => {
                        this.replyItems.push(val);
                    });
                    // console.log(this.themeInfo);
                    // console.log(this.replyItems);
                }else{
                    if(response.status===504) {
                        this.$message({
                            message: '请求超时',
                            type: 'error'
                        });
                    }
                }
                this.$loading.hide();
            },
            do_addReply: async function() {
                this.$loading.open();
                if(this.replyContent.length < 10) {
                    this.$message({
                        message: '回复内容不应少于10字符',
                        type: 'warning'
                    });
                    this.$loading.hide();
                    return;
                }
                let response = await addReply({
                    id: this.$route.params.did,
                    content: this.replyContent
                });
                console.log(response);
                if(response.status==0) {
                    this.replyContent = '';
                    this.$message({
                        message: '添加回复成功',
                        type: 'success'
                    });
                }else{
                    this.$message({
                        message: '添加回复失败: ' + response.message,
                        type: 'error'
                    });
                }
                this.$loading.hide();
            }
        }
    }
</script>

<style lang="scss" scoped>
    .discuss-detail {
        position: relative;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        overflow-y: scroll;
        padding-left: 25px;
    }

    .discuss-content {
        margin: 88px auto 30px auto;
        width: 80%;
        border-radius: .6em;
        overflow: hidden;
        background: white;
        box-shadow: 0px 2px 15px rgba(0,0,0,0.08);
    }

    ul {
        padding-left: 0;
    }

    li {
        list-style-type: none;
        height: 170px;
        border-top: 1px dashed gray;
        padding: 18px 20px;
    }

    .content-head {
        height: 250px;
        border-top: none;
    }

    .reply-input-group {
        background: white;
        width: 80%;
        height: 280px;
        margin: 30px auto 88px auto;
        overflow: hidden;
        border-radius: .6em;
        box-shadow: 0px 2px 15px rgba(0,0,0,0.08);
        > textarea {
            resize: none;
            border: none;
            background: none;
            height: 100%;
            width: 100%;
            padding: 7px 10px;
        }
        .submit-reply-btn {
            position: absolute;
            background: none;
            margin-left: -100px;
            margin-top: 235px;
            height: 30px;
            border: 1px solid #4288ce;
            border-radius: 10px;
            color: #4288ce;
            width: 80px;
            cursor: pointer;
            &:hover {
                text-decoration: underline;
            }
        }
    }
</style>