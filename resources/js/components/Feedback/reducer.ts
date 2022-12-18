export const initialState = {
    isLoading: false,
    nameError: false,
    emailError: false,
    messageError: false,
    fileError: false,
    capthcaError: false,
    name: '',
    email: '',
    message: '',
    file: null,
    captcha: '',
    needVeryfy: false,
    success: false,
};

export const actionTypes = {
    SEND_FORM: 'SEND_FORM',
    SET_NAME_ERROR: 'SET_NAME_ERROR',
    SET_EMAIL_ERROR: 'SET_EMAIL_ERROR',
    SET_MESSAGE_ERROR: 'SET_MESSAGE_ERROR',
    SET_FILE_ERROR: 'SET_FILE_ERROR',
    SET_CAPTHA_ERROR: 'SET_CAPTHA_ERROR',

    SEND_SUCCESS: 'SEND_SUCCESS',
    SET_NAME: 'SET_NAME',
    SET_EMAIL: 'SET_EMAIL',
    SET_MESSAGE: 'SET_MESSAGE',
    SET_FILE: 'SET_FILE',
    SET_CAPTCHA: 'SET_CAPTCHA',
};

export function reducer(state, { type, payload }: any) {
    switch (type) {
        case actionTypes.SEND_FORM:
            return {
                ...state,
                isLoading: true,
                nameError: false,
                emailError: false,
                messageError: false,
                fileError: false,
                capthcaError: false,
            };

        case actionTypes.SET_NAME_ERROR:
            return { ...state, isLoading: false, nameError: payload };

        case actionTypes.SET_EMAIL_ERROR:
            return { ...state, isLoading: false, emailError: payload };

        case actionTypes.SET_MESSAGE_ERROR:
            return { ...state, isLoading: false, messageError: payload };

        case actionTypes.SET_FILE_ERROR:
            return { ...state, isLoading: false, fileError: payload };

        case actionTypes.SET_CAPTHA_ERROR:
            return { ...state, isLoading: false, capthcaError: payload, needVeryfy: true };

        case actionTypes.SEND_SUCCESS:
            return { ...state, isLoading: false, success: true };
        case actionTypes.SET_NAME:
            return {
                ...state,
                name: payload,
                nameError: false,
                emailError: false,
                messageError: false,
                fileError: false,
                capthcaError: false,
            };
        case actionTypes.SET_EMAIL:
            return {
                ...state,
                email: payload,
                nameError: false,
                emailError: false,
                messageError: false,
                fileError: false,
                capthcaError: false,
            };
        case actionTypes.SET_MESSAGE:
            return {
                ...state,
                message: payload,
                nameError: false,
                emailError: false,
                messageError: false,
                fileError: false,
                capthcaError: false,
            };
        case actionTypes.SET_FILE:
            return {
                ...state,
                file: payload,
                nameError: false,
                emailError: false,
                messageError: false,
                fileError: false,
                capthcaError: false,
            };
        case actionTypes.SET_CAPTCHA:
            return {
                ...state,
                captcha: payload,
                nameError: false,
                emailError: false,
                messageError: false,
                fileError: false,
                capthcaError: false,
            };

        default:
            return state;
    }
}
