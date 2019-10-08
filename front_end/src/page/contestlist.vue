<template>
    <div class="contestlist">
        <!-- TODO 正在进行 -->
        <div class="contest-card" v-for="index in items.length">
            <div class="contest-content" @click="goto(items[index-1].id)">
                <span class="contest-title">{{items[index-1].title}}</span>
                <span class="contest-sub-title">{{items[index-1].time | timeFilter}}</span>
            </div>
        </div>
        <!-- TODO 即将到来 -->
        <!-- TODO 已经结束 -->
    </div>
</template>

<script>
    import { getContestList } from "../api/getData";

    export default {
        name: "contestpage",
        data() {
            return {
                items: [
                    // {
                    //     id: '1000',
                    //     title: '2019年武汉理工大学第二届新生赛',
                    //     time: '2019.11.16 test',
                    // },
                ]
            }
        },
        methods: {
            renderList: async function() {
                let response = await getContestList();
                if(response.status == 0) {
                    let data = response.data;
                    data.forEach((val, index) => {
                        let res = {
                            id: val.contesnt_id.toString(),
                            title: val.contest_name,
                            time: val.begin_time
                        };
                        this.contestData.push(res);
                    });
                }else{
                    // console.log('here');
                }
            },
            goto: function(link) {
                if(link=='')return;
                this.$router.push('/contest/'+link);
            }
        },
        async mounted() {
            this.renderList();
        },
        filters: {
            timeFilter: function(val) {
                return val.slice(0, val.indexOf(' '));
            }
        }
    }
</script>

<style scoped>
    .contestlist {
        position: relative;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        overflow-y: scroll;
        padding-left: 25px;
    }

    .contest-card {
        background: url('../../assets/media/test.jpeg');
        border-radius: .5em;
        width: 90%;
        height: 180px;
        display: flex;
        align-items: center;
        margin: 0 auto 10px auto;
        overflow: hidden;
        min-width: 875px;
        max-width: 990px;
        cursor: pointer;
    }

    .contest-card:first-child {
        margin-top: 88px;
    }

    .contest-content {
        display: flex;
        flex-direction: column;
        position: relative;
        background: linear-gradient(-225deg, rgba(28, 28, 28, .6) 0%, rgba(48, 48, 48, .3) 100%);
        width: 100%;
        height: 100%;
    }

    .contest-title {
        position: relative;
        color: white;
        font-weight: bold;
        font-size: 25px;
        top: 30px;
        left: 30px;
    }

    .contest-sub-title {
        font-size: 18px;
        color: white;
        position: relative;
        top: 25px;
        left: 30px;
    }
</style>