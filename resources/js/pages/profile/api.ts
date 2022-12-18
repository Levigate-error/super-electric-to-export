import { patchData, postData, deleteData } from '../../utils/requests';

export const saveProfileSettings = async params => {
    const response = await patchData({ url: 'api/user/profile', params });

    return response;
};

export const updatePAssword = async params => {
    const response = await patchData({ url: 'api/user/password', params });

    return response;
};

export const uploadPhoto = async ({ file }: any) => {
    let formData = new FormData();
    formData.append('photo', file);

    const response = await postData({
        url: '/api/user/profile/photo',
        params: formData,
        headers: {
            headers: {
                'Content-Type': 'multipart/form-data',
                Accept: 'application/json',
            },
        },
    });

    return response;
};

export const removeUser = async () => {
    const response = await deleteData({ url: 'api/user' });

    return response;
};
