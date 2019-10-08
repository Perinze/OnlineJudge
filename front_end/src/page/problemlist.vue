<template>
    <div class="problemlist">
        <div class="problem-element" v-for="index in items.length">
            <i class="icon" v-bind:class="items[index-1].status+'-icon'"></i>
            <span class="problem-id">{{items[index-1].id}}</span>
            <span class="problem-title" @click="goto(items[index-1].id)">{{items[index-1].title}}</span>
            <span class="problem-statistics">{{items[index-1].statistics.ac + '/' + items[index-1].statistics.all}}</span>
        </div>
    </div>
</template>

<script>
    import { getProblemList } from "../api/getData";

    export default {
        name: "problemlist",
        data() {
            return {
                items: [
                    // {
                    //     id: 1000,
                    //     status: 'ac',
                    //     title: '超级玛丽游戏',
                    //     statistics: {
                    //         ac: 28,
                    //         all: 188
                    //     }
                    // },
                    // {
                    //     id: 1001,
                    //     status: 'wa',
                    //     title: 'A+B Problem',
                    //     statistics: {
                    //         ac: 28,
                    //         all: 188
                    //     }
                    // },
                    // {
                    //     id: 1002,
                    //     status: 'tle',
                    //     title: '过河卒',
                    //     statistics: {
                    //         ac: 28,
                    //         all: 188
                    //     }
                    // },
                    // {
                    //     id: 1003,
                    //     status: 'mle',
                    //     title: '铺地毯',
                    //     statistics: {
                    //         ac: 28,
                    //         all: 188
                    //     }
                    // },
                    // {
                    //     id: 1004,
                    //     status: 'other',
                    //     title: '方格取数',
                    //     statistics: {
                    //         ac: 28,
                    //         all: 188
                    //     }
                    // },
                    // {
                    //     id: 1005,
                    //     status: 'un',
                    //     title: '矩阵取数游戏',
                    //     statistics: {
                    //         ac: 28,
                    //         all: 188
                    //     }
                    // }
                ]
            }
        },
        async mounted() {
            await this.renderProblemList();
        },
        methods: {
            goto: function(link) {
                this.$router.push('/problem/'+link);
            },
            renderProblemList: async function() {
                let response = await getProblemList();
                if(response.status == 0) {
                    // success
                    let data = response.data;
                    data.forEach( (val, index) => {
                        let res = {
                            id: val.problem_id,
                            status: 'un',
                            title: val.title,
                            statistics: {
                                ac: val.ac,
                                all: val.ac + val.wa
                            }
                        };
                        this.items.push(res);
                    });
                }else{
                    // error
                }
            }
        }
    }
</script>

<style scoped>
    .problemlist {
        position: relative;
    }

    .problem-element {
        position: relative;
        background: white;
        width: 75%;
        height: 45px;
        margin: 0 auto 10px auto;
        border-radius: .5em;
        display: flex;
        align-items: center;
        padding: 0 5px;
        min-width: 875px;
        max-width: 990px;
    }

    .problem-element:first-child {
        margin-top: 88px;
    }

    .icon {
        content: ' ';
        width: 27px;
        text-align: center;
        font-weight: bold;
        font-style: normal;
        font-size: 18px;
    }

    .problem-id {
        font-weight: bold;
        font-style: italic;
        margin-left: 7px;
    }

    .problem-title {
        font-weight: bold;
        /*left: 5px;*/
        width: 58%;
        margin-left: 10px;
        cursor:pointer;
    }

    .problem-statistics {
        position: relative;
        left: 27%;
        /*right: 5px;*/
        /*float: right;*/
    }
</style>