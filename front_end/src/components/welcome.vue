<template>
    <div class="welcome" v-if="display">
        <div id="function-mask" @click="close"></div>
        <div class="welcome-main" ref="card">
            <!--<div id="bezier-background">-->
                <!--<svg width="883px" height="580px" xmlns="http://www.w3.org/2000/svg" version="1.1">-->
                    <!--<path d="M0,360 C 235,340 328,70 883,280" stroke='blue' stroke-width='2' fill='none' />-->
                    <!--<path d="M0,300 C 380,175 400,460 883,340" stroke='blue' stroke-width='2' fill='none' />-->
                    <!--<path d="M0,360 C 230,345 328,70 883,280" stroke='blue' stroke-width='2' fill='none' />-->
                    <!--<path d="M0,360 C 230,345 328,70 883,280" stroke='blue' stroke-width='2' fill='none' />-->
                <!--</svg>-->
            <!--</div>-->
            <div class="welcome-view">
                <div class="welcome-view-content">
                    <span class="welcome-title">欢迎</span>
                    <span class="welcome-subtitle">感谢您选择WUTOJ，我们将为您提供最优质在线题库、赛事资讯、小组管理等服务。</span>
                    <span class="welcome-intro">WUTOJ是由武汉理工大学学生独立开发运营的在线评测系统。我们致力于为您提供最优质OJ服务，同时也欢迎您提供宝贵建议。</span>
                    <span class="welcome-logo">ACM@WUT</span>
                </div>
            </div>
            <div class="welcome-interact">
                <div class="welcome-interact-guide fade-in-out" ref="default">
                    <span class="login-guide-1">我们将引导您完成注册步骤</span>
                    <span class="login-guide-2">如果您已有账户可以选择：</span>
                    <button class="login-button" @click="call('login')">Login</button>
                    <span class="register-guide">点击下方"Sign up"按钮即可开始注册</span>
                    <button class="register-button" @click="call('register')">Sign up</button>
                    <div class="tourist-content">
                        <span class="tourist-guide">如果您还未准备好注册账户，可以选择</span>
                        <a class="tourist-a">继续以游客模式访问</a>
                        <span class="tourist-intro">您仍可以浏览页面，但个别功能无法使用</span>
                    </div>
                </div>
                <!--<div class="welcome-interact-login fade-in-out" ref="login">-->
                    <!--login-->
                <!--</div>-->
                <!--<div class="welcome-interact-register fade-in-out" ref="register">-->
                    <!--register-->
                <!--</div>-->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "welcome",
        props: {
            display: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                activeInteract: "default"
            }
        },
        methods: {
            call(anchor) {
                // console.log("here");
                // switch(anchor) {
                //     case "login":
                //         // this.activeInteract = "login";
                //         this.$refs.default.style.opacity = 0;
                //         this.$refs.register.style.opacity = 0;
                //         this.$refs.login.style.opacity = 1;
                //         return;
                //     case "register":
                //         // this.activeInteract = "register";
                //         this.$refs.default.style.opacity = 0;
                //         this.$refs.login.style.opacity = 0;
                //         this.$refs.register.style.opacity = 1;
                //         return;
                //     default:
                //         // this.activeInteract = "default";
                //         this.$refs.login.style.opacity = 0;
                //         this.$refs.register.style.opacity = 0;
                //         this.$refs.default.style.opacity = 1;
                //         return;
                // }
            },
            close() {
                this.display = false;
            }
        }
    }
</script>

<style scoped>
    .welcome {
        position: fixed;
        width: 100%;
        height: 100%;
        background: rgba(34,33,53,0.85);
        z-index: 1001;
    }

    #function-mask {
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: 1002;
    }

    .welcome-main {
        border-radius: 10px;
        overflow: hidden;
        z-index: 1003;
        margin: 10% auto 0 auto;
        transition: all .3s;
        width: 883px;
        height: 580px;
        /*background:linear-gradient(45deg,rgba(92,108,205,1) 0%,rgba(87,83,181,1) 100%);*/
        /*background:linear-gradient(228deg,rgba(135,133,214,1) 0%,rgba(17,17,29,1) 100%);*/
        background: url("../../assets/media/login_bg.png");
        display: flex;
    }

    .welcome-view {
        color: white;
        width: calc(883px - 400px);
        z-index: 1005;
    }

    .welcome-view-content > span {
        display: block;
    }

    .welcome-interact {
        z-index: 1006;
        width: 400px;
        height: 100%;
        color: black;
        background:rgba(255,255,255,.7);
    }

    .welcome-interact-guide {
    }

    .welcome-interact-guide > span {
        display: block;
    }

    .welcome-interact-login {
        opacity: 0;
    }

    .welcome-interact-register {
        opacity: 0;
    }

    /* 字体 */
    .welcome-title {
        position: relative;
        font-size: 48px;
        font-weight: 400;
        line-height: 24px;
        letter-spacing: 7px;
        top: 80px;
        left: 62px;
    }

    .welcome-subtitle {
        position: relative;
        font-size: 16px;
        width: 329px;
        top: 139px;
        left: 62px;
        line-height: 28px;
        font-weight: 400;
    }

    .welcome-intro {
        position: relative;
        top: 239px;
        left: 62px;
        width: 329px;
        height: 106px;
        font-size: 16px;
        font-weight: 400;
        line-height: 28px;
    }

    .welcome-logo {
        position: relative;
        top: 300px;
        left: 62px;
        line-height: 28px;
        font-weight: 400;
        font-size: 14px;
    }

    .login-guide-1 {
        position: relative;
        top: 66px;
        left: 58px;
        width:288px;
        height:58px;
        font-size:20px;
        font-weight:bold;
        line-height:28px;
        color:rgba(38,38,38,1);
    }

    .login-guide-2 {
        position: relative;
        top: 37px;
        left: 58px;
        font-size: 14px;
    }

    .login-button {
        position: relative;
        top: 95px;
        left: 58px;
        height: 40px;
        width: 286px;
        border:1px solid rgba(38,38,38,1);
        box-shadow:0px 3px 15px rgba(38,38,38,0);
        background: transparent;
        border-radius: 5px;
        cursor: pointer;
    }

    .login-button:hover {
        background:rgba(34,33,53,1);
        color: white;
        border: none;
    }

    .login-button:active {
        background: rgba(76,75,103,1);
    }

    .login-button:disabled {
        background:rgba(38,38,38,0);
        border:1px solid rgba(174,182,192,1);
    }

    .register-guide {
        position: relative;
        top: 126px;
        left: 71px;
        width:275px;
        height:22px;
        font-size:16px;
        font-weight:400;
        line-height:28px;
        color:rgba(38,38,38,1);
    }

    .register-button {
        position: relative;
        top: 158px;
        left: 58px;
        width:286px;
        height:40px;
        background:linear-gradient(4deg,rgba(30,30,33,1) 0%,rgba(86,85,144,1) 100%);
        box-shadow:0px 10px 15px rgba(67,65,116,0.31);
        border-radius:5px;
        border: none;
        color: white;
        cursor: pointer;
        filter: brightness(1.05);
    }

    .register-button:disabled {
        background:rgba(38,38,38,0);
        border:1px solid rgba(174,182,192,1);
    }

    .tourist-content {
        position: relative;
        top: 242px;
        left: 58px;
        height: 106px;
        width: 272px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .tourist-guide {
        position: relative;
    }

    .tourist-a {
        position: relative;
        color: #262626;
        cursor: pointer;
        margin-top: 14px;
        opacity: 0.5;
    }

    .tourist-a:hover, .tourist-a:active {
        text-decoration: underline;
        color: rgba(34,33,53,1);
        opacity: 1;
    }

    .tourist-a:disabled {
        color:rgba(188,188,203,1);
    }

    .tourist-intro {
        position: relative;
        margin-top: 13px;
    }

    /* 贝塞尔曲线 */

    #bezier-background {
        z-index: 1004;
        position: fixed;
        /*background: url("../../assets/media/login_bg.png");*/
        /*width: 100%;*/
        /*height: 100%;*/
    }

    /* Animation */

    .fade-in-out {
        transition: all .2s ease;
    }

    /* 移动端适配 */

    @media screen and (max-height: 667px) {
        .welcome-main {
            margin-top: 45px;
        }
    }

    @media screen and (max-height: 729px) and (min-height: 668px) {
        .welcome-main {
            margin-top: 63px;
        }
    }
</style>