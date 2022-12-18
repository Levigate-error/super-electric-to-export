import { postData } from '../../utils/requests';

export const getFaq = params => postData({ url: 'api/faq/get-faqs', params: { ...params, limit: 999 } });
