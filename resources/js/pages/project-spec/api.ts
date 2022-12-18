import { getData, postData, deleteData } from "../../utils/requests";

export const getSpecification = async (specId: number) => {
    const response = await getData({
        url: `api/project/specification/${specId}/sections/list`
    });
    return response;
};

export const addSection = async (title: string, id: number) => {
    const response = await postData({
        url: `api/project/specification/${id}/sections/add`,
        params: { title }
    });

    return response;
};

export const deleteSection = async (specId: number, specSectionId: number) => {
    const response = await deleteData({
        url: `api/project/specification/${specId}/sections/${specSectionId}/delete
        `
    });

    return response;
};

export const downloadSpec = async projectId => {
    const response = await getData({ url: `api/project/${projectId}/export` });
    return response;
};

export const updateProjectInfo = async projectId => {
    const response = await getData({ url: `api/project/details/${projectId}` });

    return response;
};
