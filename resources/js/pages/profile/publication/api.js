"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const requests_1 = require("../../../utils/requests");
exports.publishProfile = ({ published, show_contacts }) => {
    const response = requests_1.patchData({
        url: 'api/user/profile/published',
        params: {
            show_contacts,
            published,
        },
    });
    return response;
};
