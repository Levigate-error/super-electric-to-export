import axios from 'axios';

const getBaseUrl = () => {
    // return window.location.origin.startsWith('http://localhost:')
    //     ? 'https://superelektrik.ru'
    //     : window.location.origin
    return window.location.origin
}

export const getData = async ({ url, params = {} }) => {
    try {
        const response = await axios.get(`${getBaseUrl()}/${url}`, {
            params,
        });
        return response;
    } catch (err) {
        return err;
    }
};

export const getOuterData = async ({ url, params = {} }) => {
    try {
        const response = await axios.get(`${url}`, {
            params,
        });
        return response;
    } catch (err) {
        return err;
    }
};

type TPost = {
    url: string;
    params?: any;
    headers?: any;
};

export const postData = ({ url, params, headers = {} }: TPost) => {
    return axios
        .post(`${getBaseUrl()}/${url}`, params, headers)
        .then(res => {
            return res;
        })
        .catch(err => {
            const {
                response: {data},
            } = err;
            return data;
        });
}

export const postTestData = ({ url, params, headers = {} }: TPost) =>
    axios
        .post(`${url}`, params, headers)
        .then(res => {
            return res;
        })
        .catch(err => {
            const {
                response: { data },
            } = err;
            return data;
        });

export const deleteData = ({ url, params = {} }) =>
    axios
        .delete(`${getBaseUrl()}/${url}`, params)
        .then(res => {
            return res;
        })
        .catch(err => {
            const {
                response: { data },
            } = err;
            return data;
        });

export const patchData = async ({ url, params }) =>
    axios
        .patch(`${getBaseUrl()}/${url}`, params)
        .then(res => {
            return res;
        })
        .catch(err => {
            const {
                response: { data },
            } = err;
            return data;
        });
