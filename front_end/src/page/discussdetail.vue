<template>
    <div class="discuss-detail">

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

    }
</style>