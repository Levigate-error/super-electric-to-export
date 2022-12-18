export const initalState = {
    fetch: false,
    error: false,
    name: '',
    nameError: false,
    lastname: '',
    lastnameError: false,
    birthday: '',
    birthdayError: false,
    city_id: null,
    cityError: false,
    phone: '',
    phoneError: false,
    email: '',
    emailError: false,
    password: '',
    passwordError: false,
    passwordRepeat: '',
    passwordRepeatError: false,
    privacy: false,
    privacyError: false,
    subscription: false,
    subscriptionError: false,
    success: false,
};

export const actionTypes = {
    SET_NAME: 'SET_NAME',
    SET_NAME_ERROR: 'SET_NAME_ERROR',
    SET_LASTNAME: 'SET_LASTNAME',
    SET_LASTNAME_ERROR: 'SET_LASTNAME_ERROR',
    SET_BIRTHDAY: 'SET_BIRTHDAY',
    SET_BIRTHDAY_ERROR: 'SET_BIRTHDAY_ERROR',
    SET_CITY: 'SET_CITY',
    SET_CITY_ERROR: 'SET_CITY_ERROR',
    SET_PHONE: 'SET_PHONE',
    SET_PHONE_ERROR: 'SET_PHONE_ERROR',
    SET_EMAIL: 'SET_EMAIL',
    SET_EMAIL_ERROR: 'SET_EMAIL_ERROR',
    SET_PASSWORD: 'SET_PASSWORD',
    SET_PASSWORD_ERROR: 'SET_PASSWORD_ERROR',
    SET_REPEAT_PASSWORD: 'SET_REPEAT_PASSWORD',
    SET_REPEAT_PASSWORD_ERROR: 'SET_REPEAT_PASSWORD_ERROR',
    SET_PRIVACY: 'SET_PRIVACY',
    SET_PRIVACY_ERROR: 'SET_PRIVACY_ERROR',
    SET_SUBSCRIPTION: 'SET_SUBSCRIPTION',
    SET_SUBSCRIPTION_ERROR: 'SET_SUBSCRIPTION_ERROR',

    REGISTER: 'REGISTER',
    REGISTER_FAILURE: 'REGISTER_FAILURE',
    REGISTER_SUCCESS: 'REGISTER_SUCCESS',
};

export function reducer(state, { type, payload }: any) {
    switch (type) {
        case actionTypes.SET_NAME:
            return { ...state, name: payload, nameError: false, error: false };
        case actionTypes.SET_NAME_ERROR:
            return { ...state, nameError: payload };
        case actionTypes.SET_LASTNAME:
            return {
                ...state,
                lastname: payload,
                lastnameError: false,
                error: false,
            };
        case actionTypes.SET_LASTNAME_ERROR:
            return { ...state, lastnameError: payload };
        case actionTypes.SET_BIRTHDAY:
            return {
                ...state,
                birthday: payload,
                birthdayError: false,
                error: false,
            };
        case actionTypes.SET_BIRTHDAY_ERROR:
            return { ...state, birthdayError: payload };
        case actionTypes.SET_CITY:
            return {
                ...state,
                city_id: payload,
                cityError: false,
                error: false,
            };
        case actionTypes.SET_CITY_ERROR:
            return { ...state, cityError: payload };
        case actionTypes.SET_PHONE:
            return {
                ...state,
                phone: payload,
                phoneError: false,
                error: false,
            };
        case actionTypes.SET_PHONE_ERROR:
            return { ...state, phoneError: payload };
        case actionTypes.SET_EMAIL:
            return {
                ...state,
                email: payload,
                emailError: false,
                error: false,
            };
        case actionTypes.SET_EMAIL_ERROR:
            return { ...state, emailError: payload };
        case actionTypes.SET_PASSWORD:
            return {
                ...state,
                password: payload,
                passwordError: false,
                error: false,
            };
        case actionTypes.SET_PASSWORD_ERROR:
            return { ...state, passwordError: payload };
        case actionTypes.SET_REPEAT_PASSWORD:
            return {
                ...state,
                passwordRepeat: payload,
                passwordRepeatError: false,
                error: false,
            };
        case actionTypes.SET_REPEAT_PASSWORD_ERROR:
            return { ...state, passwordRepeatError: payload };
        case actionTypes.SET_PRIVACY:
            return {
                ...state,
                privacy: payload,
                privacyError: false,
                error: false,
            };
        case actionTypes.SET_PRIVACY_ERROR:
            return { ...state, privacyError: payload };
        case actionTypes.SET_SUBSCRIPTION:
            return {
                ...state,
                subscription: payload,
                subscriptionError: false,
                error: false,
            };
        case actionTypes.SET_SUBSCRIPTION_ERROR:
            return { ...state, subscriptionError: payload };
        case actionTypes.REGISTER:
            return { ...state, fetch: true, error: false, success: false };
        case actionTypes.REGISTER_FAILURE:
            return { ...state, fetch: false, error: payload, success: false };
        case actionTypes.REGISTER_SUCCESS:
            return { ...state, fetch: false, success: payload };
        default:
            return state;
    }
}
