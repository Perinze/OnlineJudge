import fetch from "../config/fetch";

// TODO 获取某场比赛的讨论列表
export const getDiscussList = (id, page) => fetch(`/discussions/contest/${id}/${page}`);

// TODO 获取某场比赛的某个讨论内容
export const getDiscussDetail = (id, page) => fetch(`/discussions/${id}/${page}`);

// TODO 提问问题/发表讨论板
export const addDiscuss = (data) => fetch("/discussions", "post", data);

// TODO 回复问题
export const addReply = (data) => fetch("/replies", "post", data);

// TODO 获取所有讨论
export const getAllDiscussion = () => fetch("/discussions");