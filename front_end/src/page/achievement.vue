<template>
    <div class="container">
<!--            <img src="../../assets/background/knowledgeTree.png" class="backimage">-->
        <!--   星级排行，下一版再进行使用     -->
        <progressbar :rank="9999" :barwidth="50" :now="600" :total="1000"></progressbar>

    </div>
</template>

<script>

import progressbar from "../components/progressbar"
import { getAllKnowledge } from "../api/getData"

    export default {
        name: "achievement",
        components: {progressbar},
        data() {
            return {
                items :[
                    {
                        title: 1,
                    }
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
                console.log(response);
                if (response.status == 0) {
                    let data = response.data;

                }
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
    /*.backimage {*/
        /*position: fixed;*/
        /*height: 100%;*/
    /*}*/
</style>
