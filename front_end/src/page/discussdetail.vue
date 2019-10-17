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
    </div>
</template>

<script>
    import { getDiscussDetail } from "../api/getData";

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
                ]
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
            }
        }
    }
</script>

<style scoped>
    .discuss-detail {
        position: relative;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        overflow-y: scroll;
        padding-left: 25px;
    }

    .discuss-content {
        margin: 88px auto 88px auto;
        width: 80%;
        border-radius: .6em;
        overflow: hidden;
        background: white;
        -webkit-box-shadow:0px 2px 15px rgba(0,0,0,0.08);
        -moz-box-shadow: 0px 2px 15px rgba(0,0,0,0.08);
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
</style>