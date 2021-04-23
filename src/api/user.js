import fetch from "../config/fetch";

// 获取用户信息
export const getUserInfo = (id) => fetch(`/users/${id}`);

//  更改用户信息 put method
export const changeUserInfo = (id, data) => fetch(`/users/${id}`, "put", data);

// 查找用户
export const searchUser = (user_id) => fetch(`/users/${user_id}`, "get");
