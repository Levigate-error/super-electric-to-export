import { postData } from '../../../../utils/requests';

export const register = async ({
    name,
    lastname,
    birthday,
    city_id,
    phone,
    email,
    password,
    passwordRepeat,
    privacy,
    subscription,
    csrf,
}) => {
    const response = await postData({
        url: 'register',
        params: {
            first_name: name,
            last_name: lastname,
            birthday,
            email_subscription: subscription,
            city_id,
            phone,
            email,
            password,
            password_confirmation: passwordRepeat,
            personal_data_agreement: privacy,
            _token: csrf,
        },
    });

    return response;
};
