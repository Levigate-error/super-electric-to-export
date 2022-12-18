import { postData } from '../../utils/requests';

type TSerch = {
    video_category_id?: number;
    limit?: number;
    page?: number;
    search?: string;
};

export const searchVideo = (params: TSerch) => {
    return postData({ url: `api/video/search`, params: { ...params, limit: 1000 } });
};
