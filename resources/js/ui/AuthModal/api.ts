import { TAuth } from './types';
import { postData } from '../../utils/requests';

export const userAuth = async (params: TAuth) => {
    const response = postData({
        url: 'login',
        params,
    });
    return response;
};
