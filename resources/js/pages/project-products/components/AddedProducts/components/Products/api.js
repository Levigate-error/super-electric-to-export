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
const requests_1 = require("../../../../../../utils/requests");
exports.addProductRequest = (params) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.postData({
        url: 'api/project/product/add',
        params,
    });
    return response;
});
exports.updateProduct = (params, projectId, productId) => __awaiter(this, void 0, void 0, function* () {
    return yield requests_1.patchData({
        url: `api/project/${projectId}/product/${productId}/update`,
        params,
    });
});
