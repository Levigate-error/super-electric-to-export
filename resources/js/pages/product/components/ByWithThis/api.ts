import { getData, postData } from '../../../../utils/requests';

export const getOthers = async (id: number): Promise<any> =>
    await getData({ url: `api/catalog/products/${id}/buy-with-it` });

export const addToFavorites = async (product: number) => {
    const response = await postData({
        url: 'api/catalog/products/add-to-favorite',
        params: {
            product,
        },
    });
    return response;
};

export const removeFromFavorites = async (product: number) => {
    const response = await postData({
        url: 'api/catalog/products/remove-from-favorite',
        params: {
            product,
        },
    });
    return response;
};
