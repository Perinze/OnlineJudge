<template>
    <div class="container">
        <h1 class="title">{{this.$route.params.title || '无标题'}}</h1>
        <div class="info">
            <div class="info-content" v-html="this.$route.params.content || '<p>无内容</p>'"></div>
            <!-- <div class="imgs">
              <div class="img-item"></div>
              <div class="img-item"></div>
              <div class="img-item"></div>
              <div class="img-item"></div>
            </div>-->
            <!-- <button class="btn-add-reply">评论</button> -->
        </div>
        <div class="reply-list">
            <div class="reply-list-item" v-for="item in replys" :key="item.id">
                <div class="reply-list-item-header">
                    <div class="avatar"></div>
                    <span class="name">{{item.nick}}</span>
                </div>
                <p class="content">{{item.content}}</p>
            </div>
        </div>
        <textarea
                name="reply"
                class="reply-input"
                rows="10"
                placeholder="在此输入评论内容..."
                maxlength="200"
                v-model="content"
        ></textarea>
        <button class="btn-add-reply" @click="addReply">评论</button>
    </div>
</template>

<script>
    import { getDiscussDetail, addReply } from "../api/getData";
    import pagination from "../components/pagination";
    export default {
        name: "topicInfo",
        components: { pagination },
        data() {
            return {
                replys: [
                    // { id: 12, avatar: "", content: "This is a comment." },
                    // { id: 14, avatar: "", content: "This is a comment." },
                    // { id: 15, avatar: "", content: "This is a comment." }
                ],
                count: 0,
                content: ""
            };
        },
        mounted() {
            window.console.log(this.$route);
            this.fetchReply();
        },
        methods: {
            fetchReply: function(index = 0) {
                let params = {
                    discuss_id: this.$route.params.id,
                    page: index
                };
                getDiscussDetail(params).then(res => {
                    window.console.log(res);
                    if (res.status === -1) return;
                    this.replys = res.data.reply.data;
                    this.count = res.data.reply.count;
                });
            },
            toAddDiscussion: function() {
                this.$router.push("/addDiscussion");
            },
            addReply: function() {
                addReply({
                    id: this.$route.params.id,
                    content: this.content
                }).then(res => {
                    window.console.log(res);
                    if (res.status === 0) {
                        this.$message({ message: "评论成功!", type: "success" });
                        this.content = "";
                    }
                });
            }
        }
    };
</script>

<style lang="scss" scoped>
    .container {
        padding: 44px 71px;
    }
    .title {
        font-size: 28px;
        font-weight: bold;
        color: rgba(112, 112, 112, 1);
    }
    .info {
        width: 100%;
        padding: 30px 40px;
        background: rgba(237, 239, 243, 1);
        box-shadow: 0px 7px 9px 0px rgba(4, 0, 0, 0.1);
        border-radius: 15px;
        font-size: 18px;
        font-weight: 400;
        color: rgba(98, 98, 98, 1);
        margin-bottom: 30px;
    }
    .imgs {
        display: flex;
        flex-wrap: wrap;
    }
    .img-item {
        width: 291px;
        height: 163px;
        margin: 10px;
        flex-shrink: 0;
        background: #fff;
    }
    .btn-add-reply {
        width: 111px;
        height: 26px;
        margin-top: 10px;
        background: rgba(66, 136, 206, 1);
        border-radius: 12px;
        font-size: 13px;
        font-weight: bold;
        color: rgba(255, 255, 255, 1);
        float: right;
    }
    .reply-list {
        width: 100%;
        padding: 0 30px;
        background: rgba(251, 251, 251, 1);
        border-radius: 8px;
        margin-bottom: 40px;
    }
    .reply-list-item {
        padding: 0 10px;
        padding: 30px 0;
        border-bottom: 1px solid rgba(210, 210, 210, 1);
    }
    .reply-list-item:last-of-type {
        border: none;
    }
    .reply-list-item-header {
        display: flex;
        align-items: center;
        margin-bottom: 19px;
    }
    .avatar {
        width: 42px;
        height: 42px;
        background: rgba(170, 170, 170, 1);
        border-radius: 50%;
        margin-right: 11px;
    }
    .name {
        font-size: 20px;
        font-weight: bold;
        color: rgba(125, 125, 125, 1);
    }
    .content {
        font-size: 18px;
        font-weight: 400;
        color: rgba(98, 98, 98, 1);
        margin: 0;
    }
    .reply-input {
        width: 100%;
        background: #fff;
        border-radius: 8px;
        padding: 10px;
        border: none;
    }
</style>
