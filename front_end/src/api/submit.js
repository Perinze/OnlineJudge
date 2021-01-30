import fetch from "../config/fetch";

// TODO
export const submitCode = (data) => fetch("/submit", "post", data);