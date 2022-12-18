import { postData } from "../../utils/requests";

export const createProject = async () => {
    const response = await postData({
        url: "/api/project/create",
        params: {
            title: "Проект"
        }
    });

    return response;
};

export const logout = async csrf => {
    const response = await postData({
        url: "logout",
        params: {
            _token: csrf
        }
    });

    return response;
};
