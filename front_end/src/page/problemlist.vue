<template>
    <div class="problemlist">
        <div class="problem-element" v-for="index in items.length" :key="'problem-'+index">
            <div class="problem-info">
                <i class="icon" v-bind:class="items[index-1].status+'-icon'"></i>
                <span class="problem-id" @click="goto(items[index-1].id)">{{items[index-1].id}}</span>
                <span class="problem-title" @click="goto(items[index-1].id)">{{items[index-1].title}}</span>
            </div>
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
        async beforeMount() {
            await this.renderProblemList();
        },
        methods: {
            goto: function(pid) {
                // let res = '/problem?p='+pid;
                // this.$router.push(res);
                this.$emit('open-problem', {
                    pid: pid
                });
            },
            renderProblemList: async function() {
                this.$loading.open();
                let response = await getProblemList();
                if(response.status == 0) {
                    // success
                    let data = response.data.data;
                    data.forEach( val => {
                        let res = {
                            id: val.problem_id,
                            status: 'un',
                            title: val.title,
                            statistics: {
                                ac: parseInt(val.ac),
                                all: parseInt(val.ac) + parseInt(val.wa) + parseInt(val.tle) + parseInt(val.mle) + parseInt(val.re) + +parseInt(val.ce) + parseInt(val.se)
                            }
                        };
                        this.items.push(res);
                    });
                }else{
                    // error
                    if(response.status===504) {
                        this.$message({
                            message: '请求超时',
                            type: 'error'
                        })
                    }
                }
                this.$loading.hide();
            }
        }
    }
</script>

<style lang="scss" scoped>
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
        justify-content: space-between;
        align-items: center;
        padding: 0 5px;
        min-width: 500px;
        max-width: 990px;
        &:first-child {
            margin-top: 88px;
        }
        &:last-child {
            margin-bottom: 80px;
        }
        > div {
            display: flex;
            align-items: center;
        }
    }

    .icon {
        content: ' ';
        width: 27px;
        text-align: center;
        cursor: pointer;
        font: {
            style: normal;
            size: 18px;
            weight: bold;
        }
    }

    .problem-id {
        font: {
            weight: bold;
            style: italic;
        }
        margin-left: 7px;
    }

    .problem-title {
        font-weight: bold;
        /*left: 5px;*/
        /*width: 58%;*/
        margin-left: 10px;
        cursor:pointer;
    }

    .problem-statistics {
        text-align: center;
        width: 120px;
    }
</style>