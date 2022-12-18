"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const reducer_1 = require("./reducer");
exports.setErrorHelper = (dispatch, errors) => {
    if (errors.first_name)
        dispatch({
            type: reducer_1.actionTypes.SET_NAME_ERROR,
            payload: errors.first_name[0],
        });
    if (errors.last_name)
        dispatch({
            type: reducer_1.actionTypes.SET_LASTNAME_ERROR,
            payload: errors.last_name[0],
        });
    if (errors.birthday)
        dispatch({
            type: reducer_1.actionTypes.SET_BIRTHDAY_ERROR,
            payload: errors.birthday[0],
        });
    if (errors.city_id)
        dispatch({
            type: reducer_1.actionTypes.SET_CITY_ERROR,
            payload: errors.city_id[0],
        });
    if (errors.email)
        dispatch({
            type: reducer_1.actionTypes.SET_EMAIL_ERROR,
            payload: errors.email[0],
        });
    if (errors.password)
        dispatch({
            type: reducer_1.actionTypes.SET_PASSWORD_ERROR,
            payload: errors.password[0],
        });
    if (errors.phone)
        dispatch({
            type: reducer_1.actionTypes.SET_PHONE_ERROR,
            payload: errors.phone[0],
        });
    if (errors.personal_data_agreement) {
        dispatch({
            type: reducer_1.actionTypes.SET_PRIVACY_ERROR,
            payload: errors.personal_data_agreement[0],
        });
    }
    if (errors.email_subscription) {
        dispatch({
            type: reducer_1.actionTypes.SET_SUBSCRIPTION_ERROR,
            payload: errors.email_subscription[0],
        });
    }
    if (errors.password_confirmation) {
        dispatch({
            type: reducer_1.actionTypes.SET_REPEAT_PASSWORD_ERROR,
            payload: errors.password_confirmation[0],
        });
    }
};
