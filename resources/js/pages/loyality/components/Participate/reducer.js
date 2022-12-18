"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.initialState = {
    step: 1,
    vin: "",
    isLoading: false,
    codeError: false,
    error: false,
    loyaltyError: false
};
exports.actionTypes = {
    SET_STEP: "SET_STEP",
    SET_VIN: "SET_VIN",
    REGISTER: "REGISTER",
    CODE_ERROR: "CODE_ERROR",
    FIELD_ERROR: "FIELD_ERROR",
    LOYALTY_ID_ERROR: "LOYALTY_ID_ERROR"
};
// TODO: loyalty_id error
function reducer(state, { type, payload }) {
    switch (type) {
        case exports.actionTypes.REGISTER:
            return Object.assign({}, state, { isLoading: true, error: false, codeError: false, loyaltyError: false });
        case exports.actionTypes.SET_VIN:
            return Object.assign({}, state, { vin: payload });
        case exports.actionTypes.SET_STEP:
            return Object.assign({}, state, { step: payload });
        case exports.actionTypes.FIELD_ERROR:
            return Object.assign({}, state, { isLoading: false, error: payload });
        case exports.actionTypes.CODE_ERROR:
            return Object.assign({}, state, { isLoading: false, codeError: payload });
        case exports.actionTypes.LOYALTY_ID_ERROR:
            return Object.assign({}, state, { isLoading: false, loyaltyError: payload });
        default:
            return state;
    }
}
exports.reducer = reducer;
