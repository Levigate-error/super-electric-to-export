"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const requests_1 = require("../../utils/requests");
exports.getFaq = params => requests_1.postData({ url: 'api/faq/get-faqs', params: Object.assign({}, params, { limit: 999 }) });
