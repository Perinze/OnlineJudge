<template>
    <div class="container">
<!--            <img src="../../assets/background/knowledgeTree.png" class="backimage">-->
        <!--   星级排行，下一版再进行使用     -->
<!--        <progressbar :rank="9999" :barwidth="50" :now="600" :total="1000"></progressbar>-->
        <div class="knowledgelist">
            <div class="knowledge" v-for="index in items.length" @click="moveToDetail(items[index-1].id,items[index-1].title)" :style="{'right': positionInfo[index-1].right + 'px','bottom': positionInfo[index-1].bottom + 'px'}">
<!--                <img src="../../assets/background/apple.png">-->
                <span class="knowledgetitle">{{items[index-1].title}}</span>
                <div class="star" v-for="val in items[index-1].point">
                    <img src="../../assets/icon/star.svg" class="starsvg">
<!--                    <img src="../../assets/icon/star.svg" class="starsvg">-->

                </div>
            </div>
        </div>
    </div>
</template>

<script>

//import progressbar from "../components/progressbar"
import { getAllKnowledge } from "../api/getData"

    export default {
        name: "achievement",
        // components: {progressbar},
        data() {
            return {
                items: [

                ],
                positionInfo: [
                    { id: 0, right: 320, bottom: 200 },
                    { id: 1, right: 400, bottom: 500 },
                    { id: 2, right: 610, bottom: 330 },
                    { id: 3, right: 450, bottom: 375 },
                    { id: 4, right: 720, bottom: 310 },
                    { id: 5, right: 810, bottom: 420 },
                    { id: 6, right: 900, bottom: 270 },
                    { id: 7, right: 580, bottom: 190 },
                ]
            }
        },

        async beforeMount() {
            await this.renderAllKnowledge();
        },

        methods: {
            renderAllKnowledge: async function(){
                // this.$loading.open();
                let response = await getAllKnowledge();
                if (response.status == 0) {
                    let data = response.data;
                    data.forEach( (val,index) => {
                        let res = {
                            id: val.id,
                            title: val.name,
                            point: val.point,
                        };
                        this.items.push(res);
                        // console.log(this.items);
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
            },
            moveToDetail: function(i,t){
                var dataId = i;
                var dataTitle = t;
                this.$router.push({
                    path: '/achievementInfo',
                    query: {
                        id: dataId,
                        title: dataTitle
                    }
                });
                console.log(this.$route.query.id,this.$route.query.title);
            }
        }
    }
</script>

<style scoped>
    .container {
        text-align: center;
        background-image: url("../../assets/background/knowledgeTree.png");
        background-position: center;
        background-repeat: no-repeat;
        background-size: 80% 100%;
        -moz-background-size: 80% 100%;
    }
    .knowledge {
        width: 100px;
        height: 100px;
        background-image: url("../../assets/background/apple.png");
        background-position: center;
        background-repeat: no-repeat;
        padding: 35px 0 0 0;
        position: absolute;
    }
    .starsvg {
        display: inline-block;
    }
</style>
