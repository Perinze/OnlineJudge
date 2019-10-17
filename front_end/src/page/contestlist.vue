<template>
    <div class="contestlist">
        <!-- TODO 正在进行 -->
        <div class="contest-card" v-for="index in items.length">
            <div class="contest-content" @click="goto(items[index-1].id)">
                <div class="content-words">
                    <span class="contest-title">{{items[index-1].title}}</span>
                    <span class="contest-sub-title">{{items[index-1].begin_time + ' — ' + items[index-1].end_time}}</span>
                </div>
                <div class="function-btn-group">
                    <!--disabled-->
                    <button class="join has-join">已经报名</button>
                </div>
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
                    //     begin_time: '2019.11.16 test',
                    //     end_time: '2019.11.16 test',
                    // },
                ]
            }
        },
        methods: {
            renderList: async function() {
                this.$loading.open();
                let response = await getContestList();
                if(response.status == 0) {
                    let data = response.data;
                    // console.log(data);
                    data.forEach((val, index) => {
                        let res = {
                            id: val.contest_id.toString(),
                            title: val.contest_name,
                            begin_time: val.begin_time,
                            end_time: val.end_time,
                        };
                        this.items.push(res);
                    });
                }else{
                    if(response.status === 504) {
                        this.$message({
                            content: '请求超时',
                            type: 'error'
                        })
                    }
                }
                this.$loading.hide();
            },
            goto: function(link) {
                if(link=='')return;
                this.$router.push('/contest/'+link);
            }
        },
        async beforeMount() {
            this.renderList();
        },
        filters: {
            timeFilter: function(val) {
                return val.slice(0, val.indexOf(' '));
            }
        }
    }
</script>

<style lang="scss" scoped>
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
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        &:first-child {
            margin-top: 88px;
        }
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

    .content-words {
        display: flex;
        flex-direction: column;
    }

    .function-btn-group {
        margin-top: 50px;
        width: 100%;
    }

    .join {
        /*left: 70%;*/
        /*position: relative;*/
        /*top: 95px;*/
        /*left: 58px;*/
        position: absolute;
        height: 40px;
        width: 120px;
        border:2px solid rgba(250, 250, 250, 1);
        box-shadow:0 3px 15px rgba(38, 38, 38, 0);
        background: rgba(38,38,38,0.3);
        border-radius: 5px;
        font-weight: bold;
        color: white;
        cursor: pointer;
        right: 25px;
        left: auto;
    }

    .can-join {

    }

    .can-join:hover {
        text-decoration: underline;
    }

    .cant-join {
        text-decoration: none;
        border:2px solid rgba(188, 188, 188, 1);
        color: rgba(188, 188, 188, 1);
    }

    .has-join {
        border:2px solid rgba(45, 183, 183, 1);
        color: rgba(45, 183, 183, 1);
    }
</style>