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
const requests_1 = require("../../../../utils/requests");
exports.fetchProductFamilies = (params) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.getData({
        url: "api/catalog/product-families",
        params: Object.assign({}, params)
    });
    return response;
});
exports.fetchFilters = (params) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.getData({
        url: "api/catalog/filters",
        params
    });
    return response;
});
exports.fetchPrpductDivisions = (params) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.getData({
        url: "api/catalog/product-divisions",
        params: Object.assign({}, params)
    });
    return response;
});
exports.fetchProducts = (params) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.postData({
        url: "api/catalog/products",
        params: Object.assign({}, params)
    });
    return response;
});
