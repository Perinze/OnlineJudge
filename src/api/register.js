import fetch from "../config/fetch";

// 注册
export const register = (data) => fetch("/register", "post", data);