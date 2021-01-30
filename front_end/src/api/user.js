import fetch from "../config/fetch";

// 获取用户信息
export const getUserInfo = (id) => fetch(`/users/${id}`);

// TODO 更改用户信息 put method
export const changeUserInfo = (id, data) => fetch(`/users/${id}`, "put", data);
