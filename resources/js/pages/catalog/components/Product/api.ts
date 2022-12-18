import { postData } from "../../../../utils/requests";

export const addToFavorites = async (product: number) => {
    const response = await postData({
        url: "api/catalog/products/add-to-favorite",
        params: {
            product
        }
    });
    return response;
};

export const removeFromFavorites = async (product: number) => {
    const response = await postData({
        url: "api/catalog/products/remove-from-favorite",
        params: {
            product
        }
    });
    return response;
};

export const getProjects = async () => {
    const response = await postData({
        url: "api/project/list",
        params: {}
    });
    return response;
};
