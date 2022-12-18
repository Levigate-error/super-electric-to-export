import {
    postData,
    patchData,
    deleteData
} from "../../../../../../utils/requests";

export const moveProduct = async ({
    specification_id,
    product_id,
    section_id,
    amount
}) => {
    const response = await postData({
        url: `api/project/specification/${specification_id}/products/move`,
        params: {
            product: product_id,
            section: section_id,
            amount
        }
    });

    return response;
};

export const replaceProduct = async ({
    specification_id,
    specification_product,
    section_from,
    section_to,
    amount
}) => {
    const response = await postData({
        url: `api/project/specification/${specification_id}/products/replace`,
        params: {
            specification_product,
            section_from,
            section_to,
            amount
        }
    });

    return response;
};

export const updateSpecProductAmount = async ({
    specification_id,
    section_product_id,
    amount
}) => {
    const response = await patchData({
        url: `api/project/specification/${specification_id}/products/${section_product_id}/update`,
        params: {
            amount
        }
    });

    return response.data;
};

export const updateSpecProductDiscount = async ({
    specification_id,
    section_product_id,
    discount
}) => {
    const response = await patchData({
        url: `api/project/specification/${specification_id}/products/${section_product_id}/update`,
        params: {
            discount
        }
    });

    return response.data;
};

export const updateSpecProductActive = async ({
    specification_id,
    section_product_id,
    active
}) => {
    const response = await patchData({
        url: `api/project/specification/${specification_id}/products/${section_product_id}/update`,
        params: {
            active
        }
    });

    return response.data;
};

interface IAddProject {
    product: number;
    projects: TProject[];
}

type TProject = {
    project: number;
    amount?: number;
    discount?: number;
    active?: number;
};

export const addProductRequest = async (params: IAddProject) => {
    const response = await postData({
        url: "api/project/product/add",
        params
    });
    return response;
};

export const projectProductUpdate = async (
    { project_id, product_id },
    params: any
) => {
    const response = await patchData({
        url: `api/project/${project_id}/product/${product_id}/update`,
        params
    });

    return response;
};

export const deleteProductFromSection = async (
    specification_id,
    specification_product_id
) => {
    const response = await deleteData({
        url: `api/project/specification/${specification_id}/products/${specification_product_id}/delete`
    });

    return response;
};

export const deleteProductFromProject = async (project_id, product_id) => {
    const response = await deleteData({
        url: `api/project/${project_id}/product/${product_id}/delete`
    });

    return response;
};
