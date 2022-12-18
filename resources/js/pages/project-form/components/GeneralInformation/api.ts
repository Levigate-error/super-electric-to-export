import { postData } from '../../../../utils/requests';

export const updateProject = ({ id, title, address, project_status_id, contacts, attributes }: any) =>
    postData({
        url: `api/project/update/${id}`,
        params: {
            title,
            address,
            project_status_id,
            contacts,
            attributes,
        },
    });
