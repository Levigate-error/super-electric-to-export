"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : new P(function (resolve) { resolve(result.value); }).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
Object.defineProperty(exports, "__esModule", { value: true });
const requests_1 = require("../../utils/requests");
exports.getAnalogsRequest = (vendorCode) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.postData({
        url: `/api/analog/search`,
        params: { vendor_code: vendorCode }
    });
    return response;
});
exports.getProjects = () => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.postData({ url: `/api/project/list`, params: {} });
    return response;
});
exports.addProduct = (params) => __awaiter(this, void 0, void 0, function* () {
    const response = requests_1.postData({
        url: `/api/project/product/add
    `,
        params
    });
    return response;
});
exports.createProject = () => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.postData({
        url: "/api/project/create",
        params: {
            title: "Новый проект"
        }
    });
    return response;
});
