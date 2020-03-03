/**
 * 配置环境文件
 */


/**
 * baseUrl: 请求域名前缀
 */


let baseUrl = 'http://acmwhut.com/api/oj/';
if(process.env.NODE_ENV === 'test') {
    // 本地测试环境
    baseUrl = 'http://dev.acmwhut.com/api/oj/';
}else{
    // 生产环境(相对路径)
    baseUrl = '/api/oj/';
}


/**
 * 百度统计
 * baidu_site_id: 站点id
 */

let baidu_site_id = '14001473';

export {
    baseUrl,
    baidu_site_id,
}
