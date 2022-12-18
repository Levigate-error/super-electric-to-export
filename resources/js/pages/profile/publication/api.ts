import { patchData } from '../../../utils/requests';

export const publishProfile = ({ published, show_contacts }: { published: boolean; show_contacts?: boolean }) => {
    const response = patchData({
        url: 'api/user/profile/published',
        params: {
            show_contacts,
            published,
        },
    });

    return response;
};
