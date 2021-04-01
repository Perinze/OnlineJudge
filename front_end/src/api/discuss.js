import fetch from "../config/fetch";

// 获取某场比赛的讨论列表
export const getDiscussList = (id, page) => fetch(`/discussions/contest/${id}?page_number=${page}`);

// 获取某场比赛的某个讨论内容
export const getDiscussDetail = (id, page) => fetch(`/discussions/discuss?discuss_id=${id}&page_number=${page}`);

// 提问问题/发表讨论板
export const addDiscuss = (data) => {
    console.log(data);
    return fetch("/discussions", "post", data);
}
// 回复问题
export const addReply = (data) => {
    console.log(data);
    return fetch("/replies", "post", data);
}

// 获取所有讨论（貌似用不到了）
export const getAllDiscussion = () => fetch("/discussions");