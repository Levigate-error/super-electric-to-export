import { postData } from '../../../../utils/requests';

type TGetNewsParams = {
    limit?: number;
    page: number;
};

export const getNews = ({ page, limit = 10 }: TGetNewsParams) =>
    postData({
        url: 'api/news/get-news',
        params: {
            page,
            limit,
        },
    });
