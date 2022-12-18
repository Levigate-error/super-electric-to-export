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
exports.moveProduct = ({ specification_id, product_id, section_id, amount }) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.postData({
        url: `api/project/specification/${specification_id}/products/move`,
        params: {
            product: product_id,
            section: section_id,
            amount
        }
    });
    return response;
});
exports.replaceProduct = ({ specification_id, specification_product, section_from, section_to, amount }) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.postData({
        url: `api/project/specification/${specification_id}/products/replace`,
        params: {
            specification_product,
            section_from,
            section_to,
            amount
        }
    });
    return response;
});
exports.updateSpecProductAmount = ({ specification_id, section_product_id, amount }) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.patchData({
        url: `api/project/specification/${specification_id}/products/${section_product_id}/update`,
        params: {
            amount
        }
    });
    return response.data;
});
exports.updateSpecProductDiscount = ({ specification_id, section_product_id, discount }) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.patchData({
        url: `api/project/specification/${specification_id}/products/${section_product_id}/update`,
        params: {
            discount
        }
    });
    return response.data;
});
exports.updateSpecProductActive = ({ specification_id, section_product_id, active }) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.patchData({
        url: `api/project/specification/${specification_id}/products/${section_product_id}/update`,
        params: {
            active
        }
    });
    return response.data;
});
exports.addProductRequest = (params) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.postData({
        url: "api/project/product/add",
        params
    });
    return response;
});
exports.projectProductUpdate = ({ project_id, product_id }, params) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.patchData({
        url: `api/project/${project_id}/product/${product_id}/update`,
        params
    });
    return response;
});
exports.deleteProductFromSection = (specification_id, specification_product_id) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.deleteData({
        url: `api/project/specification/${specification_id}/products/${specification_product_id}/delete`
    });
    return response;
});
exports.deleteProductFromProject = (project_id, product_id) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.deleteData({
        url: `api/project/${project_id}/product/${product_id}/delete`
    });
    return response;
});
