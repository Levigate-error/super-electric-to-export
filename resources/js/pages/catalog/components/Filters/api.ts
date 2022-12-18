import { TFiltersAPI, TFetchProducts } from "./types";
import { getData, postData } from "../../../../utils/requests";

export const fetchProductFamilies = async (params: any) => {
    const response = await getData({
        url: "api/catalog/product-families",
        params: { ...params }
    });
    return response;
};

export const fetchFilters = async (params: TFiltersAPI) => {
    const response = await getData({
        url: "api/catalog/filters",
        params
    });
    return response;
};

export const fetchPrpductDivisions = async (params: any) => {
    const response = await getData({
        url: "api/catalog/product-divisions",
        params: { ...params }
    });

    return response;
};

export const fetchProducts = async (params: TFetchProducts) => {
    const response = await postData({
        url: "api/catalog/products",
        params: {
            ...params
        }
    });
    return response;
};
