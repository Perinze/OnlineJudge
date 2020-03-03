export const asyncLoadCss = async (url, callback) => {
  let res = await loadCss(url);
  if (res) {
    if (callback) callback();
  } else {
    return new Error("Load css failed!");
  }
}

export const asyncLoadScript = async (url, callback) => {
  let res = await loadScript(url);
  if (res) {
    if (callback) callback();
  } else {
    return new Error("Load script failed!");
  }
}

export const asyncLoadScriptArr = async (urls, callback) => {
  let res = await loadScriptArr(urls);
  console.log(res);
}

export const loadCss = (url) => {
  return new Promise((resolve, reject) => {
    let el_head = document.getElementsByTagName('head')[0];
    let el_link = document.createElement('link');
    el_link.rel = "stylesheet";
    el_link.type = "text/css";
    el_link.href = url;
    el_head.appendChild(el_link);
    el_link.onload = () => {
      console.log(`Load ${url} successfully!`);
      resolve(true);
    }
    el_link.onerror = () => {
      reject(false);
    }
  })
}

export const loadScript = (url) => {
  return new Promise((resolve, reject) => {
    let el_body = document.getElementsByTagName('body')[0];
    let el_srcipt = document.createElement('script');
    el_srcipt.src = url;
    el_body.appendChild(el_srcipt);
    el_srcipt.onload = () => {
      console.log(`Load ${url} successfully!`);
      resolve(true);
    }
    el_srcipt.onerror = () => {
      reject(false);
    }
  })
}

export const formatImgUrl = (url) => {
  return url.replace("..", "http://dev.acmwhut.com/api");
}

const loadScriptArr = (urls) => {
  let loaderArr = [];
  for (let i = 0; i < urls.length; i++) {
    loaderArr.push(loadScript(urls[i]));
  }
  Promise.all(loaderArr).then(res => {
    return res;
  }).catch(err => {
    return err;
  })
}
