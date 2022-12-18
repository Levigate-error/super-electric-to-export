import { deleteData } from "../../../../../../../../utils/requests";

interface IRemoveProduct {
    project_id: number;
    product_id: number;
}

export const removeProduct = async ({
    project_id,
    product_id
}: IRemoveProduct) => {
    const response = await deleteData({
        url: `api/project/${project_id}/product/${product_id}/delete`
    });
    return response;
};
