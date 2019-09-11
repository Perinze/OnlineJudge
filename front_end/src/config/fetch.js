import { baseUrl } from './env'

export default async function(url = '', method = 'GET', data = {} ){
    // method大写
    method = method.toUpperCase();
    // 地址拼接
    if(url.substr(0,1)==='/') {
        url = baseUrl + url.substr(1);
    }else {
        url = baseUrl + url;
    }
    // 信息请求
    let requestConfig = {
        credentials: 'include',
        method: method,
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
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