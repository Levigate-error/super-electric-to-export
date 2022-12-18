"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const requests_1 = require("../../utils/requests");
exports.createProject = params => {
    const response = requests_1.postData({
        url: "api/project/create",
        params: Object.assign({}, params, { title: "Проект" })
    });
    return response;
};
exports.removeProject = projectId => {
    const response = requests_1.deleteData({
        url: `api/project/delete/${projectId}`
    });
    return response;
};
exports.getProjects = params => {
    const response = requests_1.postData({
        url: "api/project/list",
        params
    });
    return response;
};
