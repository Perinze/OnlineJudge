<template>
    <div class="welcome" v-if="display" @click.right="rejectContext($event)">
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
                    <!-- 导航菜单 -->
                    <div class="welcome-interact-guide welcome-interact-element"
                         v-if="activeInteract == 'default'"
                         key="default"
                    >
                        <span class="login-guide-1">我们将引导您完成注册步骤</span>
                        <span class="login-guide-2">如果您已有账户可以选择：</span>
                        <button class="login-button"
                                @click="activeInteract = 'login'"
                                :disabled="!functionAvailable.login"
                        >
                            Login
                        </button>
                        <span class="register-guide">点击下方"Sign up"按钮即可开始注册</span>
                        <button class="register-button"
                                @click="activeInteract = 'register'"
                                :disabled="!functionAvailable.register"
                        >
                            Sign up
                        </button>
                        <div class="tourist-content">
                            <span class="tourist-guide">如果您还未准备好注册账户，可以选择</span>
                            <a class="tourist-a" title="暂不可用" :disabled="!functionAvailable.tourist">继续以游客模式访问</a>
                            <span class="tourist-intro">您仍可以浏览页面，但个别功能无法使用</span>
                        </div>
                    </div>
                    <!-- 登陆菜单 -->
                    <div class="welcome-interact-login welcome-interact-element"
                         v-if="activeInteract == 'login'"
                         key="login"
                    >
                        <div class="backward-btn" @click="activeInteract = 'default'">
                            <img src="../../assets/icon/backward.svg" width="23" height="23" alt="backward">
                        </div>
                        <!--<span class="welcome-title" style="position: absolute;">登录</span>-->
                        <div class="login-icon"></div>
                        <div class="function-input-group">
                            <div :class="[firefoxCheck?'-moz-info-input-container':'info-input-container']">
                                <div>
                                    <img src="../../assets/icon/account.svg" width="23">
                                    <input class="info-input"
                                           type="text"
                                           placeholder="Account"
                                           v-model="loginInfo.nick"
                                    >
                                </div>
                                <span class="error-tips" v-show="errorMsg.type==='account'">{{errorMsg.content}}</span>
                            </div>
                            <div :class="[firefoxCheck?'-moz-info-input-container':'info-input-container']">
                                <div>
                                    <img src="../../assets/icon/lock.svg" width="23">
                                    <input class="info-input"
                                           :type="[seePass?'text':'password']"
                                           placeholder="Password"
                                           v-model="loginInfo.password"
                                    >
                                    <!--查看密码-->
                                    <img :src="[!seePass?icons.eyeHide:icons.eye]"
                                         height="23"
                                         @click="seePass = !seePass"
                                         style="cursor: pointer;"
                                    >
                                </div>
                                <span class="error-tips" v-show="errorMsg.type==='password'">{{errorMsg.content}}</span>
                            </div>
                            <div class="login-btn-container">
                                <transition name="loading">
                                    <button class="do-login-btn"
                                            :class="{'loading-login-btn': loading}"
                                            @click="do_login"
                                            :disabled="!functionAvailable.login"
                                    >
                                        <span v-show="!loading">Log in</span>
                                        <div class="lds-ripple" v-show="loading">
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </button>
                                </transition>
                            </div>

                            <div class="sub-function-btn">
                                <div class="forget-passwd-btn sub-function-btn-element">
                                    <a :disabled="!functionAvailable.forgetPassword">忘记密码</a>
                                    <!--<span>Forget Password</span>-->
                                </div>
                                <div class="login-to-register sub-function-btn-element"
                                >
                                    <a @click="activeInteract = 'register'"
                                       :disabled="!functionAvailable.register"
                                    >
                                        注册账号
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 注册菜单 -->
                    <div class="welcome-interact-register welcome-interact-element"
                         v-if="activeInteract == 'register'"
                         key="register"
                    >
                        <div class="backward-btn" @click="activeInteract = 'default'">
                            <img src="../../assets/icon/backward.svg" width="23" height="23" alt="backward">
                        </div>
                        <!--<div class="lds-ripple"><div></div><div></div></div>-->
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
                },
                loading: false,
                errorMsg: {
                    type: '',
                    content: ''
                },
                functionAvailable: {
                    login: true,
                    register: false,
                    forgetPassword: false,
                    tourist: false
                }
            }
        },
        methods: {
            close() {
                this.$emit('close');
            },
            do_login: async function() {
                this.errorMsg.type='';
                this.errorMsg.content='';
                let checkInfoPromise = new Promise((resolve, reject) => {
                    let data = this.loginInfo;
                    if(data.nick.length > 25 || data.nick.length < 1) {
                        reject("account:用户名为1-25个字符");
                    }
                    if(data.password.length < 6) {
                        reject("password:密码最少6位");
                    }
                    resolve();
                });
                checkInfoPromise.catch( async (errorMessage) => {
                    // alert(errorMessage);
                    // console.log(errorMessage);
                    this.errorMsg.type = errorMessage.slice(0, errorMessage.indexOf(':'));
                    this.errorMsg.content = errorMessage.slice(errorMessage.indexOf(':')+1);
                    // console.log(this.errorMsg);
                });
                checkInfoPromise.then( async (successMessage) => {
                    this.loading = true;
                    return;
                }).then( async () => {
                    let response = await login(this.loginInfo);
                    // 至少两秒
                    setTimeout( () => {
                        if(response.status == 0) {
                            // 成功登陆
                            this.loading = false;

                            this.$store.dispatch("login/userLogin", true);
                            localStorage.setItem("Flag", "isLogin");
                            localStorage.setItem("userId", response.data.userId);
                            localStorage.setItem("nick", response.data.nick);
                            localStorage.setItem("desc", response.data.desc);
                            localStorage.setItem("avator", response.data.avator);
                            localStorage.setItem("acCnt", response.data.acCnt);
                            localStorage.setItem("waCnt", response.data.waCnt);
                            this.$emit('logged', response.data);
                        }else{
                            // 用户名密码错误
                            // 已经登陆
                            this.errorMsg.type="password";
                            if(response.status===504) {
                                this.errorMsg.content='请求超时';
                            }else{
                                this.errorMsg.content=response.message;
                            }
                            this.loading = false;
                        }
                    }, 2000);
                });
            },
            rejectContext: function(e) {
                e.preventDefault();
            }
        },
        computed: {
            firefoxCheck: function() {
                let explorer = window.navigator.userAgent ;
                if (explorer.indexOf("Firefox") >= 0) {
                    return true;
                }
                return false;
            }
        }
    }
</script>

<style scoped>
    /* Loding Animation BEGIN */

    .lds-ripple {
        /*margin-top: 100px;*/
        display: inline-block;
        position: relative;
        width: 38px;
        height: 38px;
    }

    .lds-ripple div {
        position: absolute;
        border: 3px solid #fff;
        opacity: 1;
        border-radius: 50%;
        animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
    }

    .lds-ripple div:nth-child(2) {
        animation-delay: -0.5s;
    }

    @keyframes lds-ripple {
        0% {
            top: 18px;
            left: 18px;
            width: 0;
            height: 0;
            opacity: 1;
        }
        100% {
            top: 0px;
            left: 0px;
            width: 38px;
            height: 38px;
            opacity: 0;
        }
    }

    /* Loding Animation END */

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

    .error-tips {
        position: relative;
        display: inline-block;
        color: red;
        font-size: 12px;
        top: 8px;
    }

    .info-input-container {
        display: flex;
        flex-direction: column;
        height: 35px;
        margin-bottom: 17px;
    }

    .info-input-container > div {
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .info-input-container > div::after {
        position: absolute;
        content: '';
        margin-top: calc(35px / 2);
        width: 250px;
        height: 2px;
        border-radius: 2px;
        background: rgba(34,33,53,1);
    }

    /* -moz- firefox兼容 */

    .-moz-info-input-container {
        display: flex;
        flex-direction: column;
        height: 35px;
        margin-bottom: 17px;
    }

    .-moz-info-input-container > div {
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .-moz-info-input-container > div:after {
        position: absolute;
        content: '';
        margin-top: 30px;
        width: 250px;
        height: 2px;
        border-radius: 2px;
        background: rgba(34,33,53,1);
    }

    /* -moz- firefox 兼容 END */

    .info-input {
        background: none;
        border: none;
        height: 100%;
        width: calc(250px - 23px * 2 - 7px - 1px);
        margin-left: 7px;
    }

    .login-btn-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .do-login-btn {
        transition: background-color .2s ease;
        transition: width .4s ease;
        border: none;
        border-radius: 38px;
        width: 250px;
        height: 38px;
        cursor: pointer;
        background-color: rgba(34,33,53,1);
        color: white;
        font-weight: lighter;
        margin: 10px 0 4px 0;
    }

    .do-login-btn:hover {
        background-color: rgba(34,33,53,.9);
    }

    .do-login-btn:active {
        background-color: rgba(34,33,53,.7);
    }

    .loading-login-btn {
        /*position: relative;*/
        /*left: calc(250px - 19px);*/
        margin: 10px auto 4px auto;
        width: 38px;
        padding: 0 0;
    }

    .sub-function-btn {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        margin-top: 3px;
        padding: 0 5px;
    }

    .sub-function-btn-element {
        cursor: pointer;
    }

    .sub-function-btn-element > a:hover {
        text-decoration: underline;
    }

    .sub-function-btn-element > a:disabled {
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
        font-weight: 200;
    }

    .welcome-intro {
        position: relative;
        top: 239px;
        left: 62px;
        width: 329px;
        height: 106px;
        font-size: 16px;
        font-weight: 200;
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