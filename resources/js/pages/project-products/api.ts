import { getData, postData, deleteData } from '../../utils/requests';

export const fetchProductCategories = async () => {
    const response = await getData({
        url: 'api/catalog/product-categories',
    });
    return response.data.data;
};

type TAddCategory = {
    projectId: number;
    product_category: number;
};
export const addCategoryRequest = async ({ projectId, product_category }: TAddCategory) => {
    const response = await postData({
        url: `api/project/category/add/${projectId}`,
        params: {
            product_category,
        },
    });
    return response;
};

export const fetchProjectCategories = async (id: number) => {
    const response = await getData({
        url: `api/project/category/list/${id}`,
    });
    return response.data;
};

export const deleteCategory = (projectId: number, categoryId: number) => {
    return deleteData({ url: `api/project/${projectId}/category/${categoryId}` });
};
