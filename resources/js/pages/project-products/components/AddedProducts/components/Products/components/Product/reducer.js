"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
function reducer(state, action) {
    switch (action.type) {
        case "fetch":
            return Object.assign({}, state, { fetch: true });
        case "imgLoadingError":
            return Object.assign({}, state, { imgError: true });
        case "changeAmount":
            return Object.assign({}, state, { amount: action.payload, fetch: true });
        default:
            return state;
    }
}
exports.reducer = reducer;
