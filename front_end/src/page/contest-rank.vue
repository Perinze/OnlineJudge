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
                <td
                        :class="[rank_info[index-1].rank===''?'':
                        rank_info[index-1].rank<=prizeNum[0]?'rank-au':
                        rank_info[index-1].rank<=prizeNum[1]?'rank-ag':
                        rank_info[index-1].rank<=prizeNum[2]?'rank-cu':'']"
                >
                    {{rank_info[index-1].rank}}
                </td>
                <td
                        :class="[rank_info[index-1].rank===''?'':
                        rank_info[index-1].rank<=prizeNum[0]?'rank-au':
                        rank_info[index-1].rank<=prizeNum[1]?'rank-ag':
                        rank_info[index-1].rank<=prizeNum[2]?'rank-cu':'']"
                >
                    {{rank_info[index-1].nick}}
                </td>
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
    import { getContestRank, getContest } from "../api/getData";

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
                        rank: 1,
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
                    {
                        id: 0,
                        rank: 2,
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
                    {
                        id: 0,
                        rank: 3,
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
                    {
                        id: 0,
                        rank: 4,
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
                    {
                        id: 0,
                        rank: 5,
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
                    {
                        id: 0,
                        rank: 6,
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
                    {
                        id: 0,
                        rank: 7,
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
                    {
                        id: 0,
                        rank: 8,
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
                    {
                        id: 0,
                        rank: 9,
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
                    {
                        id: 0,
                        rank: 10,
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
                ],
                total: 0
            }
        },
        async created() {
            await this.getContestInfo();
            this.renderRankList();
        },
        methods: {
            getContestInfo: async function() {
                let response = await getContest({
                    contest_id: this.$route.params.id
                });
                if(response.status==0){
                    this.contest_info = {
                        title: response.data.contest_name,
                        problems: response.data.problems,
                        prize: response.data.prize
                    }
                }else{
                    this.$message({
                        message: response.message,
                        type: 'error'
                    })
                }
            },
            renderRankList: async function() {
                this.total = 0;
                // this.rank_info = [];
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
                    this.total = cnt-1;
                }else{
                    this.$message({
                        message: response.message,
                        type: 'error'
                    });
                }
            }
        },
        computed: {
            contest_id: function() {
                return this.$route.params.id;
            },
            /**
             * 返回金银铜排名
             * @returns {Array}[3] = [Au last rank, Ag last rank, Cu last rank]
             */
            prizeNum: function() {
                let total = this.total;
                let data = this.contest_info.prize;
                let res = [];
                for(let i=0;i<3;i++) {
                    let num = 0;
                    if(String(data[i]).indexOf('.')!==-1) {
                        // 小数
                        num = total * parseFloat(data[i]);
                    }else if(String(data[i]).indexOf('%')!==-1) {
                        // 百分数
                        num = total * parseFloat(String(data[i]).replace("%", ""))/100;
                    }else{
                        // 整数
                        num = parseInt(data[i]);
                    }

                    res[i] = num;
                    if(i!==0){
                        res[i]+=res[i-1];
                    }
                }
                return res;
            }
        }
    }
</script>

<style lang="scss" scoped>
    // sass变量
    $auColor: rgb(242,192,86);
    $agColor: rgb(233,233,216);
    $cuColor: rgb(186,110,64);

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

    .rank {
        &-au {
            color: $auColor;
        }
        &-ag {
            color: $agColor;
        }
        &-cu {
            color: $cuColor;
        }
    }

    .solved-info-data {

    }
</style>