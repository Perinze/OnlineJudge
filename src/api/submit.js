import fetch from "../config/fetch";

export const submitCode = (data) => fetch("/submit", "post", data);