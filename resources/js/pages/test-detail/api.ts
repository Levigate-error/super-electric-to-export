import { postData } from '../../utils/requests';

export const registerResult = async ({ id, questions }) =>
    await postData({ url: `/api/tests/${id}`, params: { questions } });
