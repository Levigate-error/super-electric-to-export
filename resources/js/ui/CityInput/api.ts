import { postData } from "../../utils/requests";

export const getList = async value => {
    const response = await postData({
        url: "api/city/search",
        params: { title: value }
    });

    return response;
};
