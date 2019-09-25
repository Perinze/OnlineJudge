<template>
    <div class="welcome"  @click="reverse_action()" v-if="display">
        <div class="welcome-main" ref="card">
            <div id="bezier-background">
                <div id="bezier-1"></div>
                <div id="bezier-2"></div>
                <div id="bezier-3"></div>
                <div id="bezier-4"></div>
            </div>
            <div class="welcome-view">
                <div class="welcome-view-content">
                    <span class="welcome-title">欢迎</span>
                    <span class="welcome-subtitle">感谢您选择WUTOJ，我们将为您提供最优质在线题库、赛事资讯、小组管理等服务。</span>
                    <span class="welcome-intro">WUTOJ是由武汉理工大学学生独立开发运营的在线评测系统。我们致力于为您提供最优质OJ服务，同时也欢迎您提供宝贵建议。</span>
                    <span class="welcome-logo">ACM@WUT</span>
                </div>
            </div>
            <div class="welcome-interact">
                <span class="login-guide-1">我们将引导您完成注册步骤</span>
                <span class="login-guide-2">如果您已有账户可以选择：</span>
                <button class="login-button">Login</button>
                <span class="register-guide">点击下方"Sign up"按钮即可开始注册</span>
                <button class="register-button">Sign up</button>
                <div class="tourist-content">
                    <span class="tourist-guide">如果您还未准备好注册账户，可以选择</span>
                    <a class="tourist-a">继续以游客模式访问</a>
                    <span class="tourist-intro">您仍可以浏览页面，但个别功能无法使用</span>
                </div>
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
                
            }
        },
        methods: {
            reverse_action() {
                // console.log('here');
                // this.$refs.card.style.transform = 'rotateX(180deg)';
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
        background:linear-gradient(228deg,rgba(135,133,214,1) 0%,rgba(17,17,29,1) 100%);
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

    .welcome-interact > span {
        display: block;
    }

    /* 字体 */
    .welcome-title {
        position: relative;
        font-size: 48px;
        font-weight: bold;
        line-height: 24px;
        letter-spacing: 10px;
        top: 67px;
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
        top: 67px;
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
        top: 38px;
        left: 58px;
        font-size: 14px;
    }

    .login-button {
        position: relative;
        top: 72px;
        left: 58px;
        height: 40px;
        width: 286px;
        border:1px solid rgba(38,38,38,1);
        box-shadow:0px 3px 15px rgba(38,38,38,0);
        background: transparent;
        border-radius: 5px;
    }

    .register-guide {
        position: relative;
        top: 103px;
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
        top: 135px;
        left: 58px;
        width:286px;
        height:40px;
        background:linear-gradient(4deg,rgba(30,30,33,1) 0%,rgba(86,85,144,1) 100%);
        box-shadow:0px 10px 15px rgba(67,65,116,0.31);
        border-radius:5px;
        color: white;
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
        color: gray;
        cursor: pointer;
        margin-top: 14px;
    }

    .tourist-intro {
        position: relative;
        margin-top: 13px;
    }

    /* 贝塞尔曲线 */

    #bezier-background {
        z-index: 1004;
    }

    #bezier-1 {
        transition: all 2s cubic-bezier(.9,.16,.11,1.11);
        /*cubic-bezier(.9,.16,.11,1.11)*/
    }

    #bezier-2 {

    }

    #bezier-3 {

    }

    #bezier-4 {

    }
</style>