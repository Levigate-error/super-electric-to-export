import { postData } from '../../../../utils/requests';

export const authorize = async params => {
    const response = await postData({
        url: `login`,
        params,
    });

    return response;
};
