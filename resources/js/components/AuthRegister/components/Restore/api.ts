import { postData } from "../../../../utils/requests";

export const reset = async ({ email, csrf }) => {
    const response = await postData({
        url: "password/email",
        params: {
            email,
            _token: csrf
        }
    });

    return response;
};
