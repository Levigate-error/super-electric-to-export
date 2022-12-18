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
exports.fetchProductCategories = () => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.getData({
        url: 'api/catalog/product-categories',
    });
    return response.data.data;
});
exports.addCategoryRequest = ({ projectId, product_category }) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.postData({
        url: `api/project/category/add/${projectId}`,
        params: {
            product_category,
        },
    });
    return response;
});
exports.fetchProjectCategories = (id) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.getData({
        url: `api/project/category/list/${id}`,
    });
    return response.data;
});
exports.deleteCategory = (projectId, categoryId) => {
    return requests_1.deleteData({ url: `api/project/${projectId}/category/${categoryId}` });
};
