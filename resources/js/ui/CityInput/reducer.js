"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.initialState = {
    value: "",
    list: [],
    isLoading: false,
    selectedCity: null,
    error: false
};
exports.actionTypes = {
    SET_VALUE: "SET_VALUE",
    FETCH_LIST: "FETCH_LIST",
    FETCH_FAILURE: "FETCH_FAILURE",
    FETCH_SUCCESS: "FETCH_SUCCESS",
    SELECT_ITEM: "SELECT_ITEM",
    REMOVE_SELECTED: "REMOVE_SELECTED"
};
exports.reducer = (state = exports.initialState, { type, payload }) => {
    switch (type) {
        case exports.actionTypes.SET_VALUE:
            return Object.assign({}, state, { value: payload });
        case exports.actionTypes.FETCH_LIST:
            return Object.assign({}, state, { isLoading: true, error: false });
        case exports.actionTypes.FETCH_SUCCESS:
            return Object.assign({}, state, { list: payload, isLoading: false });
        case exports.actionTypes.FETCH_FAILURE:
            return Object.assign({}, state, { isLoading: false, error: payload });
        case exports.actionTypes.SELECT_ITEM:
            return Object.assign({}, state, { selectedCity: payload.id, value: `${payload.title}` });
        default:
            return state;
    }
};
