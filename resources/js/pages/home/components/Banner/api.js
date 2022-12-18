"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const requests_1 = require("../../../../utils/requests");
exports.getBanners = () => requests_1.getData({ url: 'api/banner' });
