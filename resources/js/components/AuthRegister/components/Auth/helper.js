"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const reducer_1 = require("./reducer");
exports.setErrorHelper = (dispatch, errors) => {
    if (errors.email)
        dispatch({
            type: reducer_1.actionTypes.SET_EMAIL_ERROR,
            payload: errors.email[0]
        });
    if (errors.password)
        dispatch({
            type: reducer_1.actionTypes.SET_PASSWORD_ERROR,
            payload: errors.password[0]
        });
};
