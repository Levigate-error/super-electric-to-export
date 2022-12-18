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
exports.sendFeedback = ({ name, email, text, type, captcha }, file) => __awaiter(this, void 0, void 0, function* () {
    const formData = new FormData();
    file && formData.append('file', file);
    formData.append('name', name);
    formData.append('email', email);
    formData.append('text', text);
    formData.append('type', type);
    formData.append('g-recaptcha-response', captcha);
    const response = yield axios_1.default.post('/api/feedback', formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        },
    });
    return response;
});
