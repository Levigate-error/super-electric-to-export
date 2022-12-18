import axios from "axios";
import { postData, patchData, getData } from "../../utils/requests";

export const validateSpec = async ({ file }: any) => {
    let formData = new FormData();
    formData.append("file", file);

    const response = await axios.post(
        "/api/specification/files/check",
        formData,
        {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        }
    );

    return response;
};

export const compareProject = async (file, project_id) => {
    let formData = new FormData();
    formData.append("file", file);

    const response = await axios.post(
        `/api/project/${project_id}/compare-with-file`,
        formData,
        {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        }
    );

    return response;
};

export const createProject = async file => {
    let formData = new FormData();
    formData.append("file", file);

    const response = await axios.post(
        "/api/project/create-from-file",
        formData,
        {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        }
    );

    return response;
};

export const applyChanges = async (id, projectId) => {
    const response = await patchData({
        url: `api/project/${projectId}/apply-changes`,
        params: {
            change_id: id
        }
    });

    return response;
};

export const getProjects = async () => {
    const response = await postData({ url: `api/project/list`, params: {} });
    return response;
};

export const downloadSpecExample = async () => {
    const response = await getData({ url: `api/specification/files/example` });
    return response;
};
