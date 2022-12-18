"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
function reducer(state, { type, payload }) {
    switch (type) {
        case 'fetch':
            return Object.assign({}, state, { isLoading: true });
        case 'select-category':
            return Object.assign({}, state, { selectedCategory: payload });
        case 'set-categories':
            return Object.assign({}, state, { categories: payload, isLoading: false });
        case 'set-project-categories':
            return Object.assign({}, state, { projectCategories: payload });
        case 'add-category':
            return Object.assign({}, state, { projectCategories: payload, isLoading: false });
        default:
            return state;
    }
}
exports.reducer = reducer;
