import fetch from "../config/fetch";

// 登陆
export const login = (data) => fetch("/login", "post", data);

// 登出
export const logout = () => fetch("/logout", "post", {});

//检查登录
export const checkLogin = (data) => fetch("/checklogin", "get");