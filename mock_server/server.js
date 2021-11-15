const fetch = require("node-fetch");
const path = require("path");
const Koa = require("koa");
const koaBody = require("koa-body");
const app = new Koa();

const originBaseUrl = "http://acmwhut.com/api";

const getTime = () => {
  return (new Date()).toLocaleTimeString().slice(0,7);
}

app.use(
  koaBody({
    multipart: true,
  })
);

app.use(async (ctx, next) => {
  await next();

  const url = ctx.path;
  const method = ctx.request.method;
  const data = method === "GET" ? ctx.query : ctx.request.body;
  const headers = ctx.headers;

  let modulePath = path.join(__dirname, "/data", url);
  let ret = {};

  console.log(`[${getTime()}] request ${modulePath}`);

  try {
    const genFunc = require(modulePath);
    ret =
      typeof genFunc === "function"
        ? await genFunc(method, data || {})
        : genFunc;
    console.log(`[${getTime()}] response for ${url}`);
  } catch (e) {
    if (e.message.indexOf('Cannot find') === -1) {
      console.log(e);
      return;
    }
    console.log(`[${getTime()}] response ${url} without mock_server`);
    // file not found
    let fetchData = {
      method,
      headers,
    };
    if (method === "POST") {
      fetchData.body = JSON.stringify(data);
    }

    ret = await fetch(originBaseUrl + ctx.url, fetchData).then((res) => {
      return res.json();
    });
    console.log(`[${getTime()}] not response for ${url}`);
  }

  ctx.body = ret;
});

app.use(async (ctx) => {
  ctx.set("Access-Control-Allow-Origin", "*"); // 规定允许访问该资源的外域 URI
  ctx.set("Access-Control-Max-Age", "0"); // 设定预检请求结果的缓存时间
  ctx.set("cache-control", "no-store"); // 不使用缓存
  ctx.set("Access-Control-Allow-Credentials", "true"); // 请求可以带 Cookie 等
});

app.listen(3000);
