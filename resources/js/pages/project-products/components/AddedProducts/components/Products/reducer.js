"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
function reducer(state, { type, payload }) {
    switch (type) {
        case "fetch":
            return Object.assign({}, state, { isLoading: true, products: null });
        case "select-products":
            return Object.assign({}, state, { products: payload, isLoading: false });
        case "change-display-format":
            return Object.assign({}, state, { showAsRows: !state.showAsRows });
        default:
            return state;
    }
}
exports.reducer = reducer;
