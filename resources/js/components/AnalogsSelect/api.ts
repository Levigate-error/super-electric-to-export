import { postData } from "../../utils/requests";

export const getAnalogsRequest = async (vendorCode: string) => {
    const response = await postData({
        url: `/api/analog/search`,
        params: { vendor_code: vendorCode }
    });
    return response;
};

export const getProjects = async () => {
    const response = await postData({ url: `/api/project/list`, params: {} });
    return response;
};

type TAddProduct = {
    product: number;
    projects: TProject[];
};

type TProject = {
    amount?: number;
    project: number;
};

export const addProduct = async (params: TAddProduct) => {
    const response = postData({
        url: `/api/project/product/add
    `,
        params
    });

    return response;
};

export const createProject = async () => {
    const response = await postData({
        url: "/api/project/create",
        params: {
            title: "Новый проект"
        }
    });

    return response;
};
