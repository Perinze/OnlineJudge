<template>
    <div class="user-card" v-if="isDisplay">
        <div class="mask" @click="$emit('close')"></div>
        <div class="content" @click.self="$emit('close')"> <!-- @click.self 确保是自身触发而不是内部触发 -->
            <div class="left">
                <div><div></div></div>
                <img src="../../assets/media/avator.png" width="60" height="60">
            </div>
            <div class="main">
                <transition name="ease-fade" mode="out-in">
                    <div class="content-main" key="content-main" v-if="contentType==='main'">
                        <div class="main-top"></div>
                        <div class="main-footer">
                            <button class="feedback-group" @click="contentType='feedback'" :disabled="!funcAccess.feedback">
                                <img src="../../assets/icon/feedback.svg" width="15" height="15">
                                <span>反馈</span>
                            </button>
                        </div>
                    </div>
                    <div class="content-feedback" key="feedback" v-if="contentType==='feedback'">
                        <span @click="contentType='main'">123</span>
                    </div>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "user-card",
        props: [ 'isDisplay' ],
        data() {
            return {
                contentType: 'main', // main feedback
                funcAccess: {
                    feedback: false,
                }
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
            background: rgba(0,0,0,.1);
        }
        .content {
            display: flex;
            justify-content: flex-end;
            background: transparent;
            width: 820px;
            height: 470px;
            z-index: 1006;
            filter: drop-shadow(0 2px 15px rgba(0,0,0,0.18));
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
                    border-radius: 60px;
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
                .content-main, .content-feedback {
                    margin-left: -50px;
                    width: calc(100% + 50px);
                    padding: 13px 13px;
                }
                .content-main {
                    .main-top {
                        width: 100%;
                        height: calc(100% - 22px);
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
            }
        }
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
</style>