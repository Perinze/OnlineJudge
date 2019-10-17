import store from '../store';

/**
 * 日期格式化
 * @param date
 * @param fmt
 * @returns {*}
 */

export function formatDate(date, fmt) {
    if (/(y+)/.test(fmt)) {
        fmt = fmt.replace(RegExp.$1, (date.getFullYear() + '').substr(4 - RegExp.$1.length));
    }
    let o = {
        'M+': date.getMonth() + 1,
        'd+': date.getDate(),
        'h+': date.getHours(),
        'm+': date.getMinutes(),
        's+': date.getSeconds()
    };
    for (let k in o) {
        if (new RegExp(`(${k})`).test(fmt)) {
            let str = o[k] + '';
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length === 1) ? str : padLeftZero(str));
        }
    }
    return fmt;
}

function padLeftZero(str) {
    return ('00' + str).substr(str.length);
}


/**
 * 获取错误全称
 * @param status
 * @returns {string}
 */

export function getWholeErrorName(status) {
    let res = status.toLowerCase();
    switch(res) {
        case "ac": return 'Accept';
        case "wa": return 'Wrong Answer';
        case "tle": return 'Time Limit Error';
        case "mle": return 'Memory Limit Error';
        case "other": return 'Other Error';
        default: return 'Unknown Error';
    }
}


/**
 * 执行登出操作后前端需要做的工作
 */

export function logoutWork() {
    localStorage.removeItem("Flag");
    localStorage.removeItem("userId");
    localStorage.removeItem("nick");
    localStorage.removeItem("desc");
    localStorage.removeItem("avator");
    localStorage.removeItem("acCnt");
    localStorage.removeItem("waCnt");
    store.state.login.isLogin = false;
    store.state.login.userId = localStorage.getItem("userId");
    store.state.login.nick = localStorage.getItem("nick");
    store.state.login.desc = localStorage.getItem("desc");
    store.state.login.avator = localStorage.getItem("avator");
    store.state.login.acCnt = localStorage.getItem("acCnt");
    store.state.login.waCnt = localStorage.getItem("waCnt");
}
