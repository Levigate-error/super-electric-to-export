"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.initalState = {
    fetch: false,
    email: "",
    emailError: false,
    error: false,
    success: false
};
exports.actionTypes = {
    RESET_REQUEST: "RESET_REQUEST",
    SET_EMAIL: "SET_EMAIL",
    SET_EMAIL_ERROR: "SET_EMAIL_ERROR",
    RESET_FAILURE: "RESET_FAILURE",
    RESET_SUCCESS: "RESET_SUCCESS"
};
function reducer(state, { type, payload }) {
    switch (type) {
        case exports.actionTypes.SET_EMAIL:
            return Object.assign({}, state, { email: payload, error: false, emailError: false });
        case exports.actionTypes.SET_EMAIL_ERROR:
            return Object.assign({}, state, { emailError: payload });
        case exports.actionTypes.RESET_REQUEST:
            return Object.assign({}, state, { fetch: true, error: false, success: false });
        case exports.actionTypes.RESET_FAILURE:
            return Object.assign({}, state, { error: payload, fetch: false });
        case exports.actionTypes.RESET_SUCCESS:
            return Object.assign({}, state, { fetch: false, success: true });
        default:
            return state;
    }
}
exports.reducer = reducer;
