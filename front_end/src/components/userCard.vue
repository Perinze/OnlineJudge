<template>
    <div class="user-card">
        <div class="mask" @click="$emit('close')"></div>
        <div class="content" @click.self="$emit('close')"> <!-- @click.self 确保是自身触发而不是内部触发 -->
            <div class="left">
                <div><div></div></div>
                <img src="../../assets/media/avator.png"
                     width="60"
                     height="60"
                     @mouseover="avatorMaskDisplay=true"
                >
                <div id="avator-mask"
                     v-show="avatorMaskDisplay"
                     @mouseout="avatorMaskDisplay=false"
                     @click="uploadAvator"
                ></div>
            </div>
            <div class="main">
                <transition name="ease-fade" mode="out-in">
                    <div class="content-main" key="content-main" v-if="contentType==='main'">
                        <div class="main-top">
                            <transition name="edit-button">
                                <div v-show="mainMode==='edit'">
                                    <button id="main-submit-btn" class="function-btn" @click="submitInfoChange">保存</button>
                                    <button id="main-cancel-btn" class="function-btn" @click="cancelChange">取消</button>
                                </div>
                            </transition>
                            <button id="edit-btn" class="img-btn" @click="beginChange" :disabled="!funcAccess.edit">
                                <img src="../../assets/icon/edit.svg" width="20" height="20" alt="edit">
                            </button>
                            <button id="logout-btn" class="img-btn" @click="$emit('logout')">
                                <img src="../../assets/icon/logout.svg" width="20" height="20" alt="logout">
                            </button>
                            <div class="input-group">
                                <div class="left-info">
                                    <input id="nick-input" v-model="userInfo.nick" type="text" readonly>
                                    <input id="desc-input" v-model="userInfo.desc" type="text" :readonly="mainMode!=='edit'">
                                    <div>
                                        <div>
                                            <label for="contact-input">Phone:</label>
                                            <input id="contact-input" v-model="userInfo.contact" type="text" :readonly="mainMode!=='edit'">
                                        </div>
                                        <div>
                                            <label for="mail-input">E-mail:</label>
                                            <input id="mail-input" v-model="userInfo.mail" type="text" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="real-info">
                                    <div>
                                        <label for="realname-input">姓名:</label>
                                        <input id="realname-input" v-model="userInfo.realname" type="text" :readonly="mainMode!=='edit'">
                                    </div>
                                    <div>
                                        <label for="school-input">学校:</label>
                                        <input id="school-input" v-model="userInfo.school" type="text" :readonly="mainMode!=='edit'">
                                    </div>
                                    <div>
                                        <label for="major-input">专业:</label>
                                        <input id="major-input" v-model="userInfo.major" type="text" :readonly="mainMode!=='edit'">
                                    </div>
                                    <div>
                                        <label for="class-input">班级:</label>
                                        <input id="class-input" v-model="userInfo.class" type="text" :readonly="mainMode!=='edit'">
                                    </div>
                                </div>
                            </div>
                            <div class="charts">
                                <div id="radar-chart"></div>
                            </div>
                        </div>
                        <div class="main-footer">
                            <button class="feedback-group" @click="contentType='feedback'" :disabled="!funcAccess.feedback">
                                <img src="../../assets/icon/feedback.svg" width="15" height="15">
                                <span>反馈</span>
                            </button>
                        </div>
                    </div>
                    <div class="content-feedback" key="feedback" v-if="contentType==='feedback'">
                        <img class="back-btn" src="../../assets/icon/backward.svg" width="20" height="20" @click="backToMain()">
                    </div>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "user-card",
        data() {
            return {
                contentType: 'main', // 'main' or 'feedback'
                mainMode: 'me', // Mode of Main Card ('me','edit','other')
                funcAccess: {
                    edit: true,
                    feedback: true,
                },
                userInfo: {
                    nick: 'DeAnti-',
                    desc: 'Drag me all the way to the hell.',
                    realname: '王熠弘',
                    school: '武汉理工大学',
                    major: '软件工程',
                    class: '软工zy1701',
                    contact: '18454353727',
                    mail: 'long4664030@163.com'
                },
                tmpUserInfo: null,
                radarChart: null,
                radarOption: {
                    tooltip: {},
                    legend: {
                        bottom: 20,
                        data: ['我', 'TA']
                    },
                    radar: {
                        // shape: 'circle',
                        name: {
                            textStyle: {
                                color: '#fff',
                                backgroundColor: '#999',
                                borderRadius: 3,
                                padding: [3, 5]
                            }
                        },
                        indicator: [
                            { name: '提交量', max: 6500},
                            { name: '通过率', max: 100},
                            { name: '注册时间', max: 100}
                        ]
                    },
                    series: [{
                        name: '我 vs TA',
                        type: 'radar',
                        // areaStyle: {normal: {}},
                        data : [
                            {
                                value : [4300, 14, 78],
                                name : '我'
                            },
                            {
                                value : [5000, 23, 20],
                                name : 'TA'
                            }
                        ]
                    }]
                },
                avatorMaskDisplay: false
            }
        },
        mounted() {
            this.drawRadarChart();
        },
        methods: {
            drawRadarChart(time=650) {
                // 保证渲染时有#radar-chart div
                setTimeout( () => {
                    this.radarChart = this.$echarts.init(document.getElementById('radar-chart'));
                    this.radarChart.setOption(this.radarOption);
                }, time);
            },
            beginChange() {
                // 深拷贝
                this.tmpUserInfo = JSON.parse(JSON.stringify(this.userInfo));
                this.mainMode='edit';
            },
            cancelChange() {
                // 深拷贝
                this.userInfo = JSON.parse(JSON.stringify(this.tmpUserInfo));
                this.mainMode='me';
            },
            submitInfoChange: async function() {
                // TODO api
                this.mainMode='me';
            },
            backToMain() {
                this.contentType = 'main';
                this.drawRadarChart();
            },
            uploadAvator() {

            }
        },
        watch: {
            radarOption() {
                this.drawRadarChart(0);
            }
        }
    }
</script>

<style lang="scss" scoped>
    .user-card {
        position: fixed;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        z-index: 1004;
        .mask {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: 1005;
            /*background: rgba(0,0,0,.1);*/
        }
        .content {
            display: flex;
            justify-content: flex-end;
            background: transparent;
            width: 820px;
            height: 470px;
            z-index: 1006;
            filter: drop-shadow(5px 10px 5px rgba(0,0,0,0.3));
            .left {
                display: flex;
                flex-direction: column;
                justify-content: center;
                height: 100%;
                overflow: hidden;
                > div {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 70px;
                    width: 70px;
                    overflow: hidden;
                    background: transparent;
                    margin-right: -20px;
                    > div {
                        position: relative;
                        box-sizing: content-box;
                        margin-left: -70px;
                        width: 70px;
                        height: 70px;
                        background: transparent;
                        border: 30px solid white;
                        border-radius: 70px;
                    }
                }
                > img {
                    position: fixed;
                    margin-left: -30px;
                    border: 1px solid white;
                    border-radius: 100%;
                    cursor: pointer;
                    z-index: 5;
                }
                #avator-mask {
                    position: fixed;
                    background: rgba(100,100,100,0.35);
                    border: 1px solid white;
                    border-radius: 100%;
                    width: 60px;
                    height: 60px;
                    z-index: 6;
                    cursor: pointer;
                    margin-left: -30px;
                    &::before, &::after {
                        position: absolute;
                        content: '';
                        background: white;
                        opacity: 0.9;
                    }
                    &::before {
                        width: 25px;
                        height: 2px;
                    }
                    &::after {
                        width: 2px;
                        height: 25px;
                    }
                }
                &::before, &::after {
                    content: '';
                    width: calc(100px / 2);
                    height: calc((100% - 70px)/2);
                    background: white;
                }
                &::before {
                    border-top-left-radius: 10px;
                }
                &::after {
                    border-bottom-left-radius: 10px;
                }
            }
            .main {
                display: flex;
                flex-direction: row;
                width: calc(100% - 140px);
                height: 100%;
                background: white;
                border: {
                    top-right-radius: 10px;
                    bottom-right-radius: 10px;
                }
                z-index: 2;
                .content-main, .content-feedback {
                    margin-left: -50px;
                    width: calc(100% + 50px);
                    padding: 13px 13px;
                }
            }
        }
    }

    .content-main {
        padding-left: 20px;
        .main-top {
            width: 100%;
            height: calc(100% - 22px);
            padding-left: 7px;
        }
        .main-footer {
            .feedback-group {
                display: flex;
                align-items: center;
                cursor: pointer;
                border: none;
                background: none;
                > span {
                    margin-left: 2px;
                    font-size: 13px;
                }
                &:hover {
                    text-decoration: underline;
                }
                &:disabled {
                    color: gray;
                    cursor: not-allowed;
                    text-decoration: none;
                }
            }
        }
    }

    .back-btn {
        cursor: pointer;
    }

    .img-btn {
        position: absolute;
        background: none;
        border: none;
        cursor: pointer;
        right: 12px;
        &:disabled {
            cursor: not-allowed;
        }
        &::before {
            position: absolute;
            margin-top: 3px;
            left: -23px;
            font-size: 13px;
        }
    }

    #edit-btn {
        &::before {
            content: '编辑';
        }
    }

    #logout-btn {
        top: 50px;
        &::before {
            margin-top: 2px;
            content: '注销';
        }
    }

    .input-group {
        display: flex;
        align-items: flex-end;
        label {
            font-weight: bold;
        }
        .left-info>input {
            display: block;
        }
        .real-info>div>input {
            margin-top: 3px;
        }
        .real-info>div>input, .left-info>div>div>input {
            margin-left: 5px;
        }
        // all of input
        .left-info>input, .left-info>div>div>input, .real-info>div>input {
            position: relative;
            border: 1px solid #4288ce;
            border-radius: 3px;
            /*padding-left: 8px;*/
            background: none;
            transition: border 0.3s ease-in-out;
            &:read-only {
                border: 1px solid transparent;
                cursor: unset;
            }
        }

        .left-info, .real-info {
            display: inline-block;
        }
        .real-info {
            border: 1px dashed gray;
            border-radius: .5em;
            padding: 5px 10px 5px 5px;
            margin-left: 20px;
        }
        #nick-input {
            width: 250px;
            font: {
                weight: bold;
                size: 25px;
            }
        }
        #desc-input {
            width: 250px;
            margin-bottom: 39px;
            font: {
                size: 14px;
            }
        }
        #mail-input, #contact-input {
            width: 198px;
        }
    }

    .function-btn {
        position: absolute;
        border-radius: 8px;
        padding: 3px 13px;
        cursor: pointer;
        &:hover {
            text-decoration: underline;
        }
    }

    #main-submit-btn {
        right: 140px;
        background: #4288ce;
        color: white;
        border: 1px solid transparent;
    }

    #main-cancel-btn {
        right: 80px;
        border: 1px solid gray;
    }

    /*
        charts
    */

    .charts {
        display: flex;
        justify-content: center;
        width: 100%;
        padding: 0 55px 0 calc(22px - 7px);
        margin-top: 10px;
    }

    #radar-chart {
        width: 350px;
        height: 280px;
    }

    /*
        Animation
     */

    .ease-fade-enter-active {
        transition: all .3s ease;
    }

    .ease-fade-leave-active {
        transition: all .5s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }

    .ease-fade-enter, .ease-fade-leave-to {
        transform: translateX(10px);
        opacity: 0;
    }

    .edit-button {
        &-enter-active, &-leave-active {
            transition: opacity .3s ease-in-out;
        }
        &-enter, &-leave-to {
            opacity: 0;
        }
    }

    // 父级transiform原点

    .user-card {
        transform-origin: calc((100% - 820px)/2 + 90px);
    }
</style>