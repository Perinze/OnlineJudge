<template>
    <div class="discuss-list">
        <div class="list">
            <div class="element-card"
                 v-for="index in items.length"
                 @click="$router.push('/discuss/' + contest_id + '/' + items[index-1].id)"
            >
                <div class="title">{{items[index-1].title}}</div>
                <div class="content">{{items[index-1].content}}</div>
                <div class="time">{{items[index-1].time}}</div>
                <div class="user-nick">{{items[index-1].user_id}}</div>
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
        mounted() {
            this.renderList();
        },
        methods: {
            renderList: async function() {
                let response = await getDiscussList({
                    contest_id: this.$route.params.id
                });
                // console.log(response);
                if(response.status == 0) {
                    response.data.forEach( (val, index) => {
                        this.items.push(val);
                    });
                }else{

                }
            }
        },
        computed: {
            contest_id: function() {
                return this.$route.params.id;
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
        align-items: center;
        margin: 0 auto 30px auto;
        overflow: hidden;
        min-width: 875px;
        max-width: 990px;
        cursor: pointer;
    }
</style>