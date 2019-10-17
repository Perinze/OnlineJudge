<template>
    <div class="discuss-list">
        <div class="list">
            <div class="element-card"
                 v-for="index in items.length"
                 @click="$router.push('/discuss/' + contest_id + '/' + items[index-1].id)"
            >
                <div class="title">
                    <span class="problem-tag">{{items[index-1].problem_id}}</span>
                    {{items[index-1].title | titleFilter}}
                </div>
                <div class="content">{{items[index-1].content | contentFilter}}</div>
                <div class="user-nick">{{items[index-1].user_id}}</div>
                <div class="time">{{items[index-1].time}}</div>
            </div>
        </div>
    </div>
</template>

<script>
    import { getDiscussList } from "../api/getData";

    export default {
        name: "discusslist",
        data() {
            return {
                items: [
                    // {
                    //     id: '',
                    //     problem_id: '',
                    //     contest_id: '',
                    //     user_id: '',
                    //     time: '',
                    //     title: '',
                    //     content: '',
                    //     status: ''
                    // }
                ]
            }
        },
        beforeMount() {
            this.renderList();
        },
        methods: {
            renderList: async function() {
                this.$loading.open();
                let response = await getDiscussList({
                    contest_id: this.$route.params.id
                });
                // console.log(response);
                if(response.status == 0) {
                    response.data.forEach( (val, index) => {
                        this.items.push(val);
                    });
                }else{
                    if(response.status===504) {
                        this.$message({
                            message: '请求超时',
                            type: 'error'
                        })
                    }
                }
                this.$loading.hide();
            }
        },
        computed: {
            contest_id: function() {
                return this.$route.params.id;
            }
        },
        filters: {
            titleFilter: function(val) {
                let len = val.length;
                if(len<30) {
                    return val;
                }
                return val.slice(0, 27) + "...";
            },
            contentFilter: function(val) {
                let len = val.length;
                if(len<150) {
                    return val;
                }
                return val.slice(0,147) + "...";
            }
        }
    }
</script>

<style scoped>
    .discuss-list {
        position: relative;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        overflow-y: scroll;
        padding-left: 25px;
    }

    .list {

    }

    .list:first-child {
        margin-top: 88px;
    }

    .element-card {
        background: white;
        border-radius: .5em;
        width: 90%;
        height: 150px;
        display: flex;
        flex-direction: column;
        margin: 0 auto 30px auto;
        overflow: hidden;
        min-width: 875px;
        max-width: 990px;
        cursor: pointer;
        padding: 16px 50px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    }

    .element-card > div {
        width: 100%;
    }

    .problem-tag {
        margin-right: 7px;
    }

    .title {
        font-weight: bold;
        font-size: 17px;
    }

    .content {
        padding-right: 25px;
        height: 50px;
    }

    .user-nick {
        text-align: right;
    }

    .time {
        text-align: right;
    }
</style>