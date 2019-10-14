<template>
    <div class="welcome" v-if="display">
        <div id="function-mask" @click="close"></div>
        <div class="welcome-main" ref="card">
            <div class="welcome-view">
                <div class="welcome-view-content">
                    <span class="welcome-title">欢迎</span>
                    <span class="welcome-subtitle">感谢您选择WUTOJ，我们将为您提供最优质在线题库、赛事资讯、小组管理等服务。</span>
                    <span class="welcome-intro">WUTOJ是由武汉理工大学学生独立开发运营的在线评测系统。我们致力于为您提供最优质OJ服务，同时也欢迎您提供宝贵建议。</span>
                    <span class="welcome-logo">ACM@WUT</span>
                </div>
            </div>
            <div class="welcome-interact">
                <transition name="fadeinteract" mode="out-in">
                    <div class="welcome-interact-guide welcome-interact-element" v-if="activeInteract == 'default'" key="default">
                        <span class="login-guide-1">我们将引导您完成注册步骤</span>
                        <span class="login-guide-2">如果您已有账户可以选择：</span>
                        <button class="login-button" @click="activeInteract = 'login'">Login</button>
                        <span class="register-guide">点击下方"Sign up"按钮即可开始注册</span>
                        <button class="register-button" @click="activeInteract = 'register'" disabled>Sign up</button>
                        <div class="tourist-content">
                            <span class="tourist-guide">如果您还未准备好注册账户，可以选择</span>
                            <a class="tourist-a" title="暂不可用" disabled>继续以游客模式访问</a>
                            <span class="tourist-intro">您仍可以浏览页面，但个别功能无法使用</span>
                        </div>
                    </div>
                    <div class="welcome-interact-login welcome-interact-element" v-if="activeInteract == 'login'" key="login">
                        <div class="backward-btn" @click="activeInteract = 'default'">
                            <img src="../../assets/icon/backward.svg" width="23" height="23" alt="backward">
                        </div>
                        <div class="login-icon"></div>
                        <div class="function-input-group">
                            <div class="info-input-container">
                                <img src="../../assets/icon/account.svg" width="23">
                                <input class="info-input"
                                       type="text"
                                       placeholder="Account"
                                       v-model="loginInfo.nick"
                                >
                            </div>
                            <div class="info-input-container">
                                <img src="../../assets/icon/lock.svg" width="23">
                                <input class="info-input"
                                       :type="[seePass?'text':'password']"
                                       placeholder="Password"
                                       v-model="loginInfo.password"
                                >
                                <!--查看密码-->
                                <img :src="[seePass?icons.eyeHide:icons.eye]" height="23" @click="seePass = !seePass" style="cursor: pointer;">
                            </div>
                            <button class="do-login-btn" @click="do_login">Log in</button>
                            <div class="forget-passwd-btn">
                                <!--<span>忘记密码</span>-->
                                <span>Forget Password</span>
                            </div>
                        </div>
                    </div>
                    <div class="welcome-interact-register welcome-interact-element" v-if="activeInteract == 'register'" key="register">
                        <div class="backward-btn" @click="activeInteract = 'default'">
                            <img src="../../assets/icon/backward.svg" width="23" height="23" alt="backward">
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
    import { login } from "../api/getData";

    export default {
        name: "welcome",
        props: {
            display: {
                type: Boolean,
                default: false,
            }
        },
        data() {
            return {
                activeInteract: "default",
                seePass: false,
                icons: {
                    eye: require('../../assets/icon/eye.svg'),
                    eyeHide: require('../../assets/icon/eye-hide.svg'),
                },
                loginInfo: {
                    nick: '',
                    password: ''
                }
            }
        },
        methods: {
            close() {
                this.display = false;
            },
            do_login: async function() {
                let checkInfoPromise = new Promise((resolve, reject) => {
                    let data = this.loginInfo;
                    if(data.nick.length > 25 || data.nick.length < 1) {
                        reject("用户名为1-25个字符");
                    }
                    if(data.password.length < 6) {
                        reject("密码最少6位");
                    }
                    resolve("success");
                });
                checkInfoPromise.catch( async (errorMessage) => {
                    // console.log(errorMessage);
                    alert(errorMessage);
                });
                checkInfoPromise.then( async (successMessage) => {
                    let response = await login(this.loginInfo);
                    if(response.status == 0) {
                        // 成功登陆
                        this.$store.dispatch("userLogin", true);
                        localStorage.setItem("Flag", "isLogin");
                        this.$emit('logged', response.data);
                        // console.log('log success');
                    }else{
                        // 用户名密码错误
                        // 已经登陆
                        console.log(this.$store);
                    }
                    // console.log(response);
                });
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
        z-index: 3003;
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

    .welcome-interact-element {
        position: absolute;
        width: 400px;
        height: 580px;
        /*width: 100%;*/
        /*height: 100%;*/
        opacity: 1;
    }

    .welcome-interact-guide {
    }

    .welcome-interact-guide > span {
        display: block;
    }

    .welcome-interact-login {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .welcome-interact-register {
        display: flex;
    }

    .info-input-container {
        display: flex;
        flex-direction: row;
        align-items: center;
        height: 35px;
        margin-bottom: 17px;
    }

    .info-input-container::after {
        position: absolute;
        content: '';
        margin-top: calc(35px / 2);
        width: 250px;
        height: 2px;
        border-radius: 2px;
        background: rgba(34,33,53,1);
    }

    .info-input {
        background: none;
        border: none;
        height: 100%;
        width: calc(250px - 23px * 2 - 7px - 1px);
        margin-left: 7px;
    }

    .do-login-btn {
        transition: all .2s ease;
        border: none;
        border-radius: 37px;
        width: 250px;
        height: 37px;
        cursor: pointer;
        background: rgba(34,33,53,1);
        color: white;
        font-weight: lighter;
        margin: 10px 0 4px 0;
    }

    .do-login-btn:hover {
        background: rgba(34,33,53,.9);
    }

    .do-login-btn:active {
        background: rgba(34,33,53,.7);
    }

    .forget-passwd-btn {
        cursor: pointer;
        text-align: center;
    }
    
    .forget-passwd-btn > span {
        display: block;
    }

    .forget-passwd-btn:hover {
        text-decoration: underline;
    }

    .forget-passwd-btn:disabled {
        text-decoration: none;
        color: gray;
    }

    .backward-btn {
        position: absolute;
        top: 20px;
        left: 20px;
        cursor: pointer;
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
        color: rgba(174,182,192,1);
        box-shadow: none;
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

    /* Animation */

    .fadeinteract-leave-active, .fadeinteract-enter-active {
        transition: opacity .3s ease;
    }

    .fadeinteract-enter, .fadeinteract-leave-to {
        opacity: 0;
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