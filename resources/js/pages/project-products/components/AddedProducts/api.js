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
exports.fetchCategoryDivisions = ({ project_id, category_id }) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.getData({
        url: `api/project/${project_id}/category/${category_id}/divisions`
    });
    return response.data;
});
exports.fetchDivisionProducts = ({ project_id, division_id }) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.getData({
        url: `api/project/${project_id}/division/${division_id}/products`
    });
    return response.data;
});
