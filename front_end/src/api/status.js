import fetch from "../config/fetch";

export const getStatusById = (data) => fetch(`/submit/id?id=${data.id}`, "get");