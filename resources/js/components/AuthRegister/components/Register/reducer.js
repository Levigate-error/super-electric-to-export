"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.initalState = {
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
exports.actionTypes = {
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
function reducer(state, { type, payload }) {
    switch (type) {
        case exports.actionTypes.SET_NAME:
            return Object.assign({}, state, { name: payload, nameError: false, error: false });
        case exports.actionTypes.SET_NAME_ERROR:
            return Object.assign({}, state, { nameError: payload });
        case exports.actionTypes.SET_LASTNAME:
            return Object.assign({}, state, { lastname: payload, lastnameError: false, error: false });
        case exports.actionTypes.SET_LASTNAME_ERROR:
            return Object.assign({}, state, { lastnameError: payload });
        case exports.actionTypes.SET_BIRTHDAY:
            return Object.assign({}, state, { birthday: payload, birthdayError: false, error: false });
        case exports.actionTypes.SET_BIRTHDAY_ERROR:
            return Object.assign({}, state, { birthdayError: payload });
        case exports.actionTypes.SET_CITY:
            return Object.assign({}, state, { city_id: payload, cityError: false, error: false });
        case exports.actionTypes.SET_CITY_ERROR:
            return Object.assign({}, state, { cityError: payload });
        case exports.actionTypes.SET_PHONE:
            return Object.assign({}, state, { phone: payload, phoneError: false, error: false });
        case exports.actionTypes.SET_PHONE_ERROR:
            return Object.assign({}, state, { phoneError: payload });
        case exports.actionTypes.SET_EMAIL:
            return Object.assign({}, state, { email: payload, emailError: false, error: false });
        case exports.actionTypes.SET_EMAIL_ERROR:
            return Object.assign({}, state, { emailError: payload });
        case exports.actionTypes.SET_PASSWORD:
            return Object.assign({}, state, { password: payload, passwordError: false, error: false });
        case exports.actionTypes.SET_PASSWORD_ERROR:
            return Object.assign({}, state, { passwordError: payload });
        case exports.actionTypes.SET_REPEAT_PASSWORD:
            return Object.assign({}, state, { passwordRepeat: payload, passwordRepeatError: false, error: false });
        case exports.actionTypes.SET_REPEAT_PASSWORD_ERROR:
            return Object.assign({}, state, { passwordRepeatError: payload });
        case exports.actionTypes.SET_PRIVACY:
            return Object.assign({}, state, { privacy: payload, privacyError: false, error: false });
        case exports.actionTypes.SET_PRIVACY_ERROR:
            return Object.assign({}, state, { privacyError: payload });
        case exports.actionTypes.SET_SUBSCRIPTION:
            return Object.assign({}, state, { subscription: payload, subscriptionError: false, error: false });
        case exports.actionTypes.SET_SUBSCRIPTION_ERROR:
            return Object.assign({}, state, { subscriptionError: payload });
        case exports.actionTypes.REGISTER:
            return Object.assign({}, state, { fetch: true, error: false, success: false });
        case exports.actionTypes.REGISTER_FAILURE:
            return Object.assign({}, state, { fetch: false, error: payload, success: false });
        case exports.actionTypes.REGISTER_SUCCESS:
            return Object.assign({}, state, { fetch: false, success: payload });
        default:
            return state;
    }
}
exports.reducer = reducer;
