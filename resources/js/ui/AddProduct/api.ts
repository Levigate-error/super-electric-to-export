import { postData } from '../../utils/requests';

interface IAddProject {
    product: number;
    projects: TProject[];
}

type TProject = {
    project: number;
    amount: number;
};
export const addProductRequest = async (params: IAddProject) => {
    const response = await postData({
        url: 'api/project/product/add',
        params,
    });
    return response;
};

export const createProject = async () => {
    const response = await postData({
        url: '/api/project/create',
        params: {
            title: 'Проект',
        },
    });

    return response;
};
