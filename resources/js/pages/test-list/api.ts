import { getData } from '../../utils/requests';

export const getTestsList = async () => await getData({ url: 'api/tests' });
