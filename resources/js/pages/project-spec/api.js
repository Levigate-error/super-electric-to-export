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
exports.getSpecification = (specId) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.getData({
        url: `api/project/specification/${specId}/sections/list`
    });
    return response;
});
exports.addSection = (title, id) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.postData({
        url: `api/project/specification/${id}/sections/add`,
        params: { title }
    });
    return response;
});
exports.deleteSection = (specId, specSectionId) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.deleteData({
        url: `api/project/specification/${specId}/sections/${specSectionId}/delete
        `
    });
    return response;
});
exports.downloadSpec = (projectId) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.getData({ url: `api/project/${projectId}/export` });
    return response;
});
exports.updateProjectInfo = (projectId) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.getData({ url: `api/project/details/${projectId}` });
    return response;
});
