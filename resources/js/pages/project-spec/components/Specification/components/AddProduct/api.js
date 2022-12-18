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
exports.searchProducts = (params) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.postData({
        url: "api/catalog/products",
        params
    });
    return response;
});
exports.addProduct = ({ product, projects }) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.postData({
        url: "api/project/product/add",
        params: {
            product,
            projects
        }
    });
    return response;
});
exports.addProductToSection = ({ specification_id, specification_section_id, product }) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.postData({
        url: `api/project/specification/${specification_id}/sections/${specification_section_id}/add-product`,
        params: {
            product
        }
    });
    return response;
});
