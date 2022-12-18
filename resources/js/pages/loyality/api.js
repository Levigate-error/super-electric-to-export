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
exports.getUploadedReceipts = () => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.getData({
        url: 'api/loyalty/uploaded-receipts'
    });
    // const response = await getOuterData({
    //     url: 'https://testlegweb.free.beeceptor.com/get-list'
    // });
    //console.log('data', response.data)
    if (response.data != undefined && Array.isArray(response.data)) {
        return response.data;
    }
    return [];
});
exports.getTotalAmount = () => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.getData({
        url: 'api/loyalty/total-amount'
    });
    // const response = await getOuterData({
    //     url: 'https://testtotalamount.free.beeceptor.com/total-amount'
    // });
    // console.log(response.data);
    // console.log(response.data.amount);
    if (response.data != undefined) {
        if (response.data.amount != undefined)
            return response.data.amount;
    }
    return 0;
});
exports.registerVIN = (vin) => __awaiter(this, void 0, void 0, function* () {
    const response = requests_1.postData({
        url: 'api/certificate/register',
        params: { code: vin },
    });
    return response;
});
exports.getLoyalityList = () => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.postData({ url: 'api/loyalty' });
    return response;
});
exports.manuallyUploadReceipt = (data) => __awaiter(this, void 0, void 0, function* () {
    const response = yield requests_1.postData({
        url: 'api/loyalty/upload-receipt',
        params: data,
    });
    return response;
});
exports.uploadPhotoReceipt = (files) => __awaiter(this, void 0, void 0, function* () {
    console.log("files2: ", files);
    let formData = new FormData();
    for (const receipt of files) {
        console.log("fr: ", receipt);
        formData.append('receipts[]', receipt, receipt.name);
    }
    const response = yield requests_1.postData({
        url: 'api/loyalty/upload-receipt',
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
exports.uploadReceipt = ({ file, loyaltyId }) => __awaiter(this, void 0, void 0, function* () {
    let formData = new FormData();
    for (const receipt of file) {
        formData.append('receipts[]', receipt, receipt.name);
    }
    formData.append('loyalty_id', loyaltyId);
    const response = yield requests_1.postData({
        url: 'api/loyalty/upload-receipt',
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
exports.getLoyaltyProposals = loyaltyId => requests_1.getData({
    url: `api/loyalty/${loyaltyId}/proposals`,
});
exports.registerProductCode = (code, loyaltyId) => __awaiter(this, void 0, void 0, function* () {
    const response = requests_1.postData({
        url: `api/loyalty/register-product-code`,
        params: { code, loyalty_id: loyaltyId },
    });
    return response;
});
exports.publishProfile = ({ published, show_contacts }) => __awaiter(this, void 0, void 0, function* () {
    const response = requests_1.patchData({
        url: 'api/user/profile/published',
        params: {
            show_contacts,
            published,
        },
    });
    return response;
});
