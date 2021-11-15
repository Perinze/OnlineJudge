import { baseUrl } from "./env";

export default async function ifetch(
  url = "",
  method = "GET",
  data = {},
  headers = {}
) {
  // 超时时间配置
  let timeout = 30 * 1000;

  // method大写
  method = method.toUpperCase();

  // headers处理
  // let header_data = Object.assign({
  //   Accept: "application/json",
  //   "Contest-Type": "application/json"
  // }, headers);
  let header_data = headers;
  if (!(data instanceof FormData)) {
    header_data["Accept"] = "application/json";
    header_data["Content-Type"] = "application/json";
  }

  // 区分站内外API地址
  if (url.indexOf("https://") === -1) {
    // 站内API
    // URL拼接
    if (url.substr(0, 1) === "/") {
      url = baseUrl + url.substr(1);
    } else {
      url = baseUrl + url;
    }
  }

  // 信息请求
  let requestConfig = {
    credentials: "include",
    method: method,
    headers: header_data,
    mode: "cors",
    cache: "force-cache",
  };

  if (method === "POST" || method === "PUT") {
    // 仅POST请求附带数据
    if (data instanceof FormData) {
      Object.defineProperty(requestConfig, "body", {
        value: data,
      });
    } else {
      Object.defineProperty(requestConfig, "body", {
        value: JSON.stringify(data),
      });
    }
  }

  if(method === "GET") {
    if(url.indexOf("?") != -1) url += '&';
    else url += '?';
    let nowTime = new Date().getTime().toString();
    url=url+`time=${nowTime.substr(nowTime.length-6, 6)}`;
  }

  let timeoutFunc = () => {
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve(
          new Response('{"status": 408, "message": "请求超时", "data": null}', {
            ok: false,
            status: 408,
            url: url,
          })
        );
      }, timeout);
    });
  };

  let fetchFunc = () => {
    return fetch(url, requestConfig)
      .then((response) => {
        let retResp = response;
        if (!response.ok) {
          retResp = new Response(
            '{"status": -1, "message": "请求错误' +
              response.status +
              '", "data": null}',
            {
              ok: false,
              status: response.status,
              url: url,
            }
          );
        }
        return retResp;
      })
      .catch((error) => {
        return new Response(
          '{"status": -1, "message": "Fail to fetch:' +
            error +
            '", "data": null}',
          {
            ok: false,
            status: 500,
            url: url,
          }
        );
      });
  };

  const retJson = Promise.race([fetchFunc(), timeoutFunc()]).then(
    (response) => {
      return response.json();
    }
  );

  return retJson;
}
