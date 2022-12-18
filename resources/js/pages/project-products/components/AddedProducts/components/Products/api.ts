import { postData, patchData } from '../../../../../../utils/requests';

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

export const updateProduct = async (params, projectId, productId) =>
    await patchData({
        url: `api/project/${projectId}/product/${productId}/update`,
        params,
    });
