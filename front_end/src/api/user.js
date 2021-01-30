import fetch from "../config/fetch";

// TODO 获取用户信息
export const getUserInfo = (id, data) => fetch(`/users/${id}`, "post", data);

// TODO 更改用户信息 put method
export const changeUserInfo = (id, data) => fetch(`/users/${id}`, "put", data);
