<template>
    <div class="contest-rank">
        <table class="rank-form"
               rules="all"
               frame="none"
               cellpadding="10"
               cellspacing="0"
               summary="你爬nm呢"
        >
            <thead>
                <tr>
                    <td>Rank</td>
                    <td>Nick</td>
                    <td>Solved</td>
                    <td>Penalty</td>
                    <td v-for="index in contest_info.problems.length">{{String.fromCharCode(index+64)}}</td>
                </tr>
            </thead>
            <tr class="rank-form-element"
                v-for="index in rank_info.length"
            >
                <td>{{rank_info[index-1].rank}}</td>
                <td>{{rank_info[index-1].nick}}</td>
                <td>{{rank_info[index-1].acNum}}</td>
                <td>{{rank_info[index-1].penalty}}</td>
                <td v-for="problemIndex in contest_info.problems.length">
                    <div class="solved-info-data">
                         <!--v-if="rank_info[index-1].solveInfo[problemIndex-1]"-->
                    <!--&gt;-->
                    </div>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
    import { getContestRank } from "../api/getData";

    export default {
        name: "contest-rank",
        data() {
            return {
                contest_info: {
                    title: '',
                    problems: [0,1,2,3,4,5,6,7,8,9],
                    prize: [2,3,4],
                },
                rank_info: [
                    {
                        id: 0,
                        rank: '1',
                        nick: 'ljwsb',
                        acNum: 1,
                        penalty: 1000,
                        solveInfo: [
                            {
                                problem_id: 0,
                                success_time: 100,
                                times: 1
                            },
                            {
                                id: 0,
                                successTime: 100,
                                times: 1
                            },
                            {
                                id: 0,
                                successTime: 100,
                                times: 1
                            },
                            {
                                id: 0,
                                successTime: 100,
                                times: 1
                            },
                            {
                                id: 0,
                                successTime: 100,
                                times: 1
                            },
                            {
                                id: 0,
                                successTime: 100,
                                times: 1
                            },
                            {
                                id: 0,
                                successTime: 100,
                                times: 1
                            },
                            {
                                id: 0,
                                successTime: 100,
                                times: 1
                            },
                            {
                                id: 0,
                                successTime: 100,
                                times: 1
                            },
                            {
                                id: 0,
                                successTime: 100,
                                times: 1
                            }
                        ]
                    },
                ]
            }
        },
        created() {
            this.renderRankList();
        },
        methods: {
            getStatus: function(rank) {
                // rank begin from 1
                if(rank <= this.contest_info.prize[0]) {
                    return 1; // 金奖
                }
                if(rank <= this.contest_info.prize[1]) {
                    return 2; // 银奖
                }
                if(rank <= this.contest_info.prize[2]) {
                    return 3; // 铜奖
                }
                return 4; // 打铁
            },
            renderRankList: async function() {
                this.$loading.open();
                let response = await getContestRank({
                    contest_id: this.$route.params.id
                });
                console.log(response);
                if(response.status == 0) {
                    let cnt = 1;
                    response.data.forEach( (val, index) => {
                        this.rank_info.push({
                            id: val.user_id,
                            rank: val.nick.indexOf('*')===0?'':cnt, // 打星
                            nick: val.nick,
                            acNum: val.ac_num,
                            penalty: val.penalty,
                            solveInfo: val.problem_id
                        });
                        // 打星逻辑
                        if(val.nick.indexOf('*')!==0){
                            cnt++;
                        }
                    });
                }else{
                    this.$message({
                        message: response.message,
                        type: 'error'
                    })
                }
                this.$loading.hide();
            }
        },
        computed: {
            contest_id: function() {
                return this.$route.params.id;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .contest-rank {
        position: relative;
        padding-left: 24px;
    }

    .rank-form {
        width: 85%;
        margin: 88px auto 60px auto;
        border: {
            color: gray;
            radius: 1em;
        }
        background: rgb(250, 250, 250);
        text-align: center;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        /*filter: blur(30px) brightness(1.15) opacity(0.80);*/
        > thead {
            font-weight: bold;
            font-style: italic;
        }
    }

    .solved-info-data {

    }
</style>