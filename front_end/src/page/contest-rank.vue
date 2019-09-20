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
            <tr class="rank-form-element" v-for="index in rank_info.length">
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
    export default {
        name: "contest-rank",
        data() {
            return {
                contest_info: {
                    title: '',
                    problems: [0,1,2,3,4,5,6,7,8,9]
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
                        rank: '1',
                        nick: 'ljwsb',
                        acNum: 1,
                        penalty: 1000,
                        solveInfo: [
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
                        rank: '1',
                        nick: 'ljwsb',
                        acNum: 1,
                        penalty: 1000,
                        solveInfo: [
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
                        rank: '1',
                        nick: 'ljwsb',
                        acNum: 1,
                        penalty: 1000,
                        solveInfo: [
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
                        rank: '1',
                        nick: 'ljwsb',
                        acNum: 1,
                        penalty: 1000,
                        solveInfo: [
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
                        rank: '1',
                        nick: 'ljwsb',
                        acNum: 1,
                        penalty: 1000,
                        solveInfo: [
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
                        rank: '1',
                        nick: 'ljwsb',
                        acNum: 1,
                        penalty: 1000,
                        solveInfo: [
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
                        rank: '1',
                        nick: 'ljwsb',
                        acNum: 1,
                        penalty: 1000,
                        solveInfo: [
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
                        rank: '1',
                        nick: 'ljwsb',
                        acNum: 1,
                        penalty: 1000,
                        solveInfo: [
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
                        rank: '1',
                        nick: 'ljwsb',
                        acNum: 1,
                        penalty: 1000,
                        solveInfo: [
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
                        rank: '1',
                        nick: 'ljwsb',
                        acNum: 1,
                        penalty: 1000,
                        solveInfo: [
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
                        rank: '1',
                        nick: 'ljwsb',
                        acNum: 1,
                        penalty: 1000,
                        solveInfo: [
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
                        rank: '1',
                        nick: 'ljwsb',
                        acNum: 1,
                        penalty: 1000,
                        solveInfo: [
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
                        rank: '1',
                        nick: 'ljwsb',
                        acNum: 1,
                        penalty: 1000,
                        solveInfo: [
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
                        rank: '1',
                        nick: 'ljwsb',
                        acNum: 1,
                        penalty: 1000,
                        solveInfo: [
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
                        rank: '1',
                        nick: 'ljwsb',
                        acNum: 1,
                        penalty: 1000,
                        solveInfo: [
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
                        rank: '1',
                        nick: 'ljwsb',
                        acNum: 1,
                        penalty: 1000,
                        solveInfo: [
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
                        rank: '1',
                        nick: 'ljwsb',
                        acNum: 1,
                        penalty: 1000,
                        solveInfo: [
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
                        rank: '1',
                        nick: 'ljwsb',
                        acNum: 1,
                        penalty: 1000,
                        solveInfo: [
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
                        rank: '1',
                        nick: 'ljwsb',
                        acNum: 1,
                        penalty: 1000,
                        solveInfo: [
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
        methods: {

        },
        computed: {
            contest_id: function() {
                return this.$route.params.id;
            }
        }
    }
</script>

<style scoped>
    .contest-rank {
        position: relative;

    }

    .rank-form {
        width: 85%;
        margin: 88px auto 60px auto;
        border-color: gray;
        border-radius: 1em;
        background: rgb(250, 250, 250);
        text-align: center;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        /*filter: blur(30px) brightness(1.15) opacity(0.80);*/
    }

    .rank-form > thead {
        font-weight: bold;
        font-style: italic;
    }

    .solved-info-data {

    }
</style>