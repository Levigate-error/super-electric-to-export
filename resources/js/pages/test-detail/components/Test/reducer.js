"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.initialState = {
    currentPage: 0,
    userAnswers: [],
    publishRequest: false,
    publishError: false,
    resultData: false,
    inProgress: false,
};
exports.actionTypes = {
    START_TEST: 'START_TEST',
    SET_PAGE: 'SET_PAGE',
    ADD_ANSWERS: 'ADD_ANSWERS',
    PUBLISH_REQUEST: 'PUBLISH_REQUEST',
    PUBLISH_FAILURE: 'PUBLISH_FAILURE',
    PUBLISH_SUCCESS: 'PUBLISH_SUCCESS',
    SET_RESULT: 'SET_RESULT',
};
function reducer(state, { type, payload }) {
    switch (type) {
        case exports.actionTypes.START_TEST:
            return Object.assign({}, state, { inProgress: true });
        case exports.actionTypes.SET_PAGE:
            return Object.assign({}, state, { currentPage: payload });
        case exports.actionTypes.ADD_ANSWERS:
            return Object.assign({}, state, { userAnswers: [...state.userAnswers, payload] });
        case exports.actionTypes.PUBLISH_REQUEST:
            return Object.assign({}, state, { publishRequest: true, publishError: false });
        case exports.actionTypes.PUBLISH_FAILURE:
            return Object.assign({}, state, { publishRequest: false, publishError: payload });
        case exports.actionTypes.PUBLISH_SUCCESS:
            return Object.assign({}, state, { publishRequest: false, resultData: payload });
        case exports.actionTypes.SET_RESULT:
            return Object.assign({}, state, { resultData: payload });
        default:
            return state;
    }
}
exports.reducer = reducer;
