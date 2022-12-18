import { postData, deleteData } from "../../utils/requests";

export const createProject = params => {
    const response = postData({
        url: "api/project/create",
        params: { ...params, title: "Проект" }
    });
    return response;
};

export const removeProject = projectId => {
    const response = deleteData({
        url: `api/project/delete/${projectId}`
    });
    return response;
};

export const getProjects = params => {
    const response = postData({
        url: "api/project/list",
        params
    });
    return response;
};
