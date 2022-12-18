"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.initialState = {
    step: 1,
    code: "",
    isLoading: false,
    error: false
};
exports.actionTypes = {
    SET_CODE: "SET_CODE",
    FETCH: "FETCH",
    FETCH_SUCCESS: "FETCH_SUCCESS",
    FETCH_FAILURE: "FATCH_FAILURE"
};
exports.reducer = (state, { type, payload }) => {
    switch (type) {
        case exports.actionTypes.SET_CODE:
            return Object.assign({}, state, { code: payload });
        case exports.actionTypes.FETCH:
            return Object.assign({}, state, { error: false, isLoading: true });
        case exports.actionTypes.FETCH_SUCCESS:
            return Object.assign({}, state, { step: 2, error: false, isLoading: false });
        case exports.actionTypes.FETCH_FAILURE:
            return Object.assign({}, state, { error: payload, isLoading: false });
        default:
            return state;
    }
};
