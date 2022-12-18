"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.initalState = {
    email: '',
    emailError: false,
    password: '',
    passwordError: false,
    remember: false,
    error: false,
    isLoading: false,
};
exports.actionTypes = {
    SET_EMAIL: 'SET_EMAIL',
    SET_EMAIL_ERROR: 'SET_EMAIL_ERROR',
    SET_PASSWORD: 'SET_PASSWORD',
    SET_PASSWORD_ERROR: 'SET_PASSWORD_ERROR',
    SET_REMEMBER: 'SET_REMEMBER',
    AUTHORIZATION: 'AUTHORIZATION',
    AUTH_FAILURE: 'AUTH_FAILURE',
};
function reducer(state, { type, payload }) {
    switch (type) {
        case exports.actionTypes.SET_EMAIL:
            return Object.assign({}, state, { email: payload, emailError: false, passwordError: false, error: false });
        case exports.actionTypes.SET_EMAIL_ERROR:
            return Object.assign({}, state, { emailError: payload });
        case exports.actionTypes.SET_PASSWORD:
            return Object.assign({}, state, { password: payload, emailError: false, passwordError: false, error: false });
        case exports.actionTypes.SET_PASSWORD_ERROR:
            return Object.assign({}, state, { passwordError: payload });
        case exports.actionTypes.SET_REMEMBER:
            return Object.assign({}, state, { remember: payload });
        case exports.actionTypes.AUTHORIZATION:
            return Object.assign({}, state, { isLoading: true, error: false });
        case exports.actionTypes.AUTH_FAILURE:
            return Object.assign({}, state, { isLoading: false, error: payload });
        default:
            return state;
    }
}
exports.reducer = reducer;
