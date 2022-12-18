"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.initialState = {
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
exports.actionTypes = {
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
function reducer(state, { type, payload }) {
    switch (type) {
        case exports.actionTypes.SEND_FORM:
            return Object.assign({}, state, { isLoading: true, nameError: false, emailError: false, messageError: false, fileError: false, capthcaError: false });
        case exports.actionTypes.SET_NAME_ERROR:
            return Object.assign({}, state, { isLoading: false, nameError: payload });
        case exports.actionTypes.SET_EMAIL_ERROR:
            return Object.assign({}, state, { isLoading: false, emailError: payload });
        case exports.actionTypes.SET_MESSAGE_ERROR:
            return Object.assign({}, state, { isLoading: false, messageError: payload });
        case exports.actionTypes.SET_FILE_ERROR:
            return Object.assign({}, state, { isLoading: false, fileError: payload });
        case exports.actionTypes.SET_CAPTHA_ERROR:
            return Object.assign({}, state, { isLoading: false, capthcaError: payload, needVeryfy: true });
        case exports.actionTypes.SEND_SUCCESS:
            return Object.assign({}, state, { isLoading: false, success: true });
        case exports.actionTypes.SET_NAME:
            return Object.assign({}, state, { name: payload, nameError: false, emailError: false, messageError: false, fileError: false, capthcaError: false });
        case exports.actionTypes.SET_EMAIL:
            return Object.assign({}, state, { email: payload, nameError: false, emailError: false, messageError: false, fileError: false, capthcaError: false });
        case exports.actionTypes.SET_MESSAGE:
            return Object.assign({}, state, { message: payload, nameError: false, emailError: false, messageError: false, fileError: false, capthcaError: false });
        case exports.actionTypes.SET_FILE:
            return Object.assign({}, state, { file: payload, nameError: false, emailError: false, messageError: false, fileError: false, capthcaError: false });
        case exports.actionTypes.SET_CAPTCHA:
            return Object.assign({}, state, { captcha: payload, nameError: false, emailError: false, messageError: false, fileError: false, capthcaError: false });
        default:
            return state;
    }
}
exports.reducer = reducer;
