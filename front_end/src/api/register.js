import fetch from "../config/fetch";

// TODO 注册
export const register = (data) => fetch("/register", "post", data);