import { getData } from '../../../../utils/requests';

export const getBanners = () => getData({ url: 'api/banner' });
