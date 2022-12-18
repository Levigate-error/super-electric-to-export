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
exports.saveProfileSettings = (params) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.patchData({ url: 'api/user/profile', params });
    return response;
});
exports.updatePAssword = (params) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.patchData({ url: 'api/user/password', params });
    return response;
});
exports.uploadPhoto = ({ file }) => __awaiter(this, void 0, void 0, function* () {
    let formData = new FormData();
    formData.append('photo', file);
    const response = yield requests_1.postData({
        url: '/api/user/profile/photo',
        params: formData,
        headers: {
            headers: {
                'Content-Type': 'multipart/form-data',
                Accept: 'application/json',
            },
        },
    });
    return response;
});
exports.removeUser = () => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.deleteData({ url: 'api/user' });
    return response;
});
