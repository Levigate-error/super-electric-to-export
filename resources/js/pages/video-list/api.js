"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const requests_1 = require("../../utils/requests");
exports.searchVideo = (params) => {
    return requests_1.postData({ url: `api/video/search`, params: Object.assign({}, params, { limit: 1000 }) });
};
