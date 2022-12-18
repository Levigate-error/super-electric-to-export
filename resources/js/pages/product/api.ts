import { postData } from "../../utils/requests";

export const addToFavorites = (product: number) => {
    const response = postData({
        url: "api/catalog/products/add-to-favorite",
        params: {
            product
        }
    });
    return response;
};

export const removeFromFavorites = (product: number) => {
    const response = postData({
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
