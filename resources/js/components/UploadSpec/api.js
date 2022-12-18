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
const axios_1 = require("axios");
const requests_1 = require("../../utils/requests");
exports.validateSpec = ({ file }) => __awaiter(this, void 0, void 0, function* () {
    let formData = new FormData();
    formData.append("file", file);
    const response = yield axios_1.default.post("/api/specification/files/check", formData, {
        headers: {
            "Content-Type": "multipart/form-data"
        }
    });
    return response;
});
exports.compareProject = (file, project_id) => __awaiter(this, void 0, void 0, function* () {
    let formData = new FormData();
    formData.append("file", file);
    const response = yield axios_1.default.post(`/api/project/${project_id}/compare-with-file`, formData, {
        headers: {
            "Content-Type": "multipart/form-data"
        }
    });
    return response;
});
exports.createProject = (file) => __awaiter(this, void 0, void 0, function* () {
    let formData = new FormData();
    formData.append("file", file);
    const response = yield axios_1.default.post("/api/project/create-from-file", formData, {
        headers: {
            "Content-Type": "multipart/form-data"
        }
    });
    return response;
});
exports.applyChanges = (id, projectId) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.patchData({
        url: `api/project/${projectId}/apply-changes`,
        params: {
            change_id: id
        }
    });
    return response;
});
exports.getProjects = () => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.postData({ url: `api/project/list`, params: {} });
    return response;
});
exports.downloadSpecExample = () => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.getData({ url: `api/specification/files/example` });
    return response;
});
