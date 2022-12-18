export const initalState = {
    email: '',
    emailError: false,
    password: '',
    passwordError: false,
    remember: false,
    error: false,
    isLoading: false,
};

export const actionTypes = {
    SET_EMAIL: 'SET_EMAIL',
    SET_EMAIL_ERROR: 'SET_EMAIL_ERROR',
    SET_PASSWORD: 'SET_PASSWORD',
    SET_PASSWORD_ERROR: 'SET_PASSWORD_ERROR',
    SET_REMEMBER: 'SET_REMEMBER',
    AUTHORIZATION: 'AUTHORIZATION',
    AUTH_FAILURE: 'AUTH_FAILURE',
};
export function reducer(state, { type, payload }: any) {
    switch (type) {
        case actionTypes.SET_EMAIL:
            return {
                ...state,
                email: payload,
                emailError: false,
                passwordError: false,
                error: false,
            };
        case actionTypes.SET_EMAIL_ERROR:
            return { ...state, emailError: payload };

        case actionTypes.SET_PASSWORD:
            return {
                ...state,
                password: payload,
                emailError: false,
                passwordError: false,
                error: false,
            };
        case actionTypes.SET_PASSWORD_ERROR:
            return { ...state, passwordError: payload };

        case actionTypes.SET_REMEMBER:
            return { ...state, remember: payload };

        case actionTypes.AUTHORIZATION:
            return { ...state, isLoading: true, error: false };
        case actionTypes.AUTH_FAILURE:
            return { ...state, isLoading: false, error: payload };
        default:
            return state;
    }
}
