import { postData } from '../../../../utils/requests';

export const getLoyaltyProducts = async (): Promise<any> =>
    await postData({
        url: 'api/catalog/products',
        params: {
            is_loyalty: 1,
            limit: 150,
        },
    });

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
