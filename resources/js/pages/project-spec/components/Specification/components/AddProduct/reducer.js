"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
function reducer(state, { type, payload }) {
    switch (type) {
        case "fetch":
            return Object.assign({}, state, { isLoading: true });
        case "open-search":
            return Object.assign({}, state, { dropdownIsVisible: true });
        case "hide-search":
            return Object.assign({}, state, { dropdownIsVisible: false });
        case "set-values":
            return Object.assign({}, state, { values: payload });
        default:
            return state;
    }
}
exports.reducer = reducer;
