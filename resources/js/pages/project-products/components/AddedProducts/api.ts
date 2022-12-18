import { getData } from "../../../../utils/requests";

export const fetchCategoryDivisions = async ({ project_id, category_id }) => {
    const response = await getData({
        url: `api/project/${project_id}/category/${category_id}/divisions`
    });
    return response.data;
};

export const fetchDivisionProducts = async ({ project_id, division_id }) => {
    const response = await getData({
        url: `api/project/${project_id}/division/${division_id}/products`
    });
    return response.data;
};
