import { baseUrl } from './env'

export default async function(url = '', method = 'GET', data = {}, headers = {} ){
    // 超时时间配置
    // var timeout = 60 * 1000;
    var timeout = 60 * 1000;
    let controller = new AbortController();
    let signal = controller.signal;

    // method大写
    method = method.toUpperCase();

    // headers处理
    let header_data = headers;
    header_data['Accept'] = 'application/json';
    header_data['Content-Type'] = 'application/json';

    // 区分站内外API地址
    if(url.indexOf('https://') == -1) {
        // 站内API
        // URL拼接
        if (url.substr(0, 1) === '/') {
            url = baseUrl + url.substr(1);
        } else {
            url = baseUrl + url;
        }
    }

    // 信息请求
    let requestConfig = {
        credentials: 'include',
        method: method,
        headers: header_data,
        mode: "cors",
        cache: "force-cache",
        signal: signal
    };

    if (method === 'POST') {
        Object.defineProperty(requestConfig, 'body', {
            value: JSON.stringify(data)
        })
    }

    let timeoutPromise = (time) => {
        return new Promise( (resolve, reject) => {
            setTimeout(() => {
                resolve(new Response("timeout", { status: 504, statusText: "timeout" }));
                controller.abort();
            },time);
        });
    };

    let requestPromise = (requestUrl, requestConf) => {
        return fetch(requestUrl, requestConf);
    };

    try {
        const ret = Promise.race([timeoutPromise(timeout), requestPromise(url, requestConfig)])
            .then(async (resp) => {
                // console.log(resp.status);
                if(resp.status == 504) {
                    // case timeout
                    const responseJson = {
                        status: 504,
                        message: '请求超时',
                        data: null
                    };
                    return responseJson;
                }else{
                    // case success
                    const responseJson = await resp.json();
                    return responseJson;
                }
                // console.log('success');
                // console.log(responseJson);
            })
            .catch(error => {
                console.log('fetch error');
                console.log(error);
            });
        return ret;
        // const response = await fetch(url, requestConfig);
        // const responseJson = await response.json();
        // return responseJson
    } catch (error) {
        throw new Error(error)
    }
}