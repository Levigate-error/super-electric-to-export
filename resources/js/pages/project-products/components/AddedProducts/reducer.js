"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
function reducer(state, { type, payload }) {
    switch (type) {
        case "fetch":
            return Object.assign({}, state, { isLoading: true, selectedDivision: null });
        case "select-division":
            return Object.assign({}, state, { selectedDivision: payload });
        case "set-divisions":
            return Object.assign({}, state, { divisions: payload, isLoading: false });
        default:
            return state;
    }
}
exports.reducer = reducer;
