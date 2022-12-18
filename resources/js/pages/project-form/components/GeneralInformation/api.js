"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const requests_1 = require("../../../../utils/requests");
exports.updateProject = ({ id, title, address, project_status_id, contacts, attributes }) => requests_1.postData({
    url: `api/project/update/${id}`,
    params: {
        title,
        address,
        project_status_id,
        contacts,
        attributes,
    },
});
