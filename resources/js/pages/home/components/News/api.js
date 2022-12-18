"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const requests_1 = require("../../../../utils/requests");
exports.getNews = ({ page, limit = 10 }) => requests_1.postData({
    url: 'api/news/get-news',
    params: {
        page,
        limit,
    },
});
