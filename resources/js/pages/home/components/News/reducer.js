"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.initialState = {
    isLoading: true,
    news: [],
    currentNews: 0,
    error: false,
};
exports.actionTypes = {
    FETCH_NEWS: 'FETCH_NEWS',
    FETCH_NEWS_SUCCESS: 'FETCH_NEWS_SUCCESS',
    FETCH_NEWS_FAILURE: 'FETCH_NEWS_FAILURE',
    SET_NEWS: 'SET_NEWS',
    SET_CURRENT_NEWS: 'SET_CURRENT_NEWS',
};
function reducer(state, { type, payload }) {
    switch (type) {
        case exports.actionTypes.FETCH_NEWS:
            return Object.assign({}, state, { isLoading: true });
        case exports.actionTypes.FETCH_NEWS_SUCCESS:
            return Object.assign({}, state, { isLoading: false, news: payload, currentNews: 0, prevAvailable: false, nextAvailable: true });
        case exports.actionTypes.FETCH_NEWS_FAILURE:
            return Object.assign({}, state, { isLoading: false, error: true });
        case exports.actionTypes.SET_NEWS:
            return Object.assign({}, state, { currentNews: payload });
        case exports.actionTypes.SET_CURRENT_NEWS:
            return Object.assign({}, state, { currentNews: payload });
        default:
            return state;
    }
}
exports.reducer = reducer;
