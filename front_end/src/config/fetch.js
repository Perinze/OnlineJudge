import { baseUrl } from './env'

export default async function(url = '', method = 'GET', data = {}, headers = {} ){
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
        cache: "force-cache"
    };

    if (method === 'POST') {
        Object.defineProperty(requestConfig, 'body', {
            value: JSON.stringify(data)
        })
    }

    try {
        const response = await fetch(url, requestConfig);
        const responseJson = await response.json();
        return responseJson
    } catch (error) {
        throw new Error(error)
    }
}