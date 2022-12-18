"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.actionTypes = {
    FAVORITES_REQUEST: 'FAVORITES_REQUEST',
    ADD_TO_FAVORITES: 'ADD_TO_FAVORITES',
    REMOVE_FROM_FAVORITES: 'REMOVE_FROM_FAVORITES',
    IMG_ERROR: 'IMG_ERROR',
};
function reducer(state, action) {
    switch (action.type) {
        case exports.actionTypes.FAVORITES_REQUEST:
            return Object.assign({}, state, { isLoading: true });
        case exports.actionTypes.ADD_TO_FAVORITES:
            return Object.assign({}, state, { isFavorites: true, isLoading: false });
        case exports.actionTypes.REMOVE_FROM_FAVORITES:
            return Object.assign({}, state, { isFavorites: false, isLoading: false });
        case exports.actionTypes.IMG_ERROR:
            return Object.assign({}, state, { imgError: true });
        default:
            return state;
    }
}
exports.reducer = reducer;
