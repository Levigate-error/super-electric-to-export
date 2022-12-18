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
exports.getLoyaltyProducts = () => __awaiter(this, void 0, void 0, function* () {
    return yield requests_1.postData({
        url: 'api/catalog/products',
        params: {
            is_loyalty: 1,
            limit: 150,
        },
    });
});
exports.addToFavorites = (product) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.postData({
        url: 'api/catalog/products/add-to-favorite',
        params: {
            product,
        },
    });
    return response;
});
exports.removeFromFavorites = (product) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.postData({
        url: 'api/catalog/products/remove-from-favorite',
        params: {
            product,
        },
    });
    return response;
});
