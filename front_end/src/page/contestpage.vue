<template>
    <div class="contestpage">
        <div class="contest-card" v-for="index in 6">
            <div class="contest-content" @click="goto(items[index-1].link)">
                <span class="contest-title">{{items[index-1].title}}</span>
                <span class="contest-sub-title">{{items[index-1].time}}</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "contestpage",
        data() {
            return {
                items: [
                    {
                        title: '2019年武汉理工大学第二届新生赛',
                        time: '2019.11.16',
                        link: ''
                    },
                    {
                        title: '2019年武汉理工大学第二届新生赛',
                        time: '2019.11.16',
                        link: ''
                    },
                    {
                        title: '2019年武汉理工大学第二届新生赛',
                        time: '2019.11.16',
                        link: ''
                    },
                    {
                        title: '2019年武汉理工大学第二届新生赛',
                        time: '2019.11.16',
                        link: ''
                    },
                    {
                        title: '2019年武汉理工大学第二届新生赛',
                        time: '2019.11.16',
                        link: ''
                    },
                    {
                        title: '2019年武汉理工大学第二届新生赛',
                        time: '2019.11.16',
                        link: ''
                    },
                ]
            }
        },
        methods: {
            goto: function(link) {

            }
        }
    }
</script>

<style scoped>
    .contestpage {
        position: relative;
        top: 88px;
        left: 12px;
    }

    .contest-card {
        background: url('../assets/test.jpeg');
        border-radius: .5em;
        width: 90%;
        height: 180px;
        display: flex;
        align-items: center;
        margin: 0 auto 10px auto;
        overflow: hidden;
        min-width: 875px;
        max-width: 990px;
        cursor:pointer;
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