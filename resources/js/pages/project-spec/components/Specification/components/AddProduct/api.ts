import { postData } from "../../../../../../utils/requests";

type TFilter = {
    search: String;
    limit: Number;
};

export const searchProducts = async (params: TFilter) => {
    const response = await postData({
        url: "api/catalog/products",
        params
    });
    return response;
};

interface TAddProduct {
    product: number;
    projects: [TProduct];
}

type TProduct = {
    amount: number;
    project: number;
};

export const addProduct = async ({ product, projects }: TAddProduct) => {
    const response = await postData({
        url: "api/project/product/add",
        params: {
            product,
            projects
        }
    });
    return response;
};

export const addProductToSection = async ({
    specification_id,
    specification_section_id,
    product
}) => {
    const response = await postData({
        url: `api/project/specification/${specification_id}/sections/${specification_section_id}/add-product`,
        params: {
            product
        }
    });
    return response;
};
