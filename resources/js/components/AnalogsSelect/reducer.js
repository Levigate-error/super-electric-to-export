"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.initialState = {
    article: '',
    analog: false,
    fetchAnalog: false,
    fetchAnalogError: false,
    fetchProjects: false,
    fetchProjectsFailure: false,
    projects: [],
    selectedProjects: [],
    product: 0,
    productAdded: false,
    addProductFailure: false,
    addRequest: false,
};
exports.actionTypes = {
    SET_ARTICLE: 'SET_ARTICLE',
    FETCH_ANALOG: 'FETCH_ANALOG',
    SET_ANALOG: 'SET_ANALOG',
    FETCH_ANALOG_FAILURE: 'FETCH_ANALOG_FAILURE',
    FETCH_PROJECTS: 'FETCH_PROJECTS',
    SET_PROJECTS: 'SET_PROJECTS',
    FETCH_PROJECTS_FAILURE: 'FETCH_PROJECTS_FAILURE',
    SET_SELECTED_PROJECTS: 'SET_SELECTED_PROJECTS',
    SET_CURRENT_PRODUCT: 'SET_CURRENT_PRODUCT',
    ADD_PRODUCT_REQUEST: 'ADD_PRODUCT_REQUEST',
    ADD_PRODUCT_FAILURE: 'ADD_PRODUCT_FAILURE',
    ADD_PRODUCT_SUCCESS: 'ADD_PRODUCT_SUCCESS',
    RESET_ADD_PRODUCT_ACTION: 'RESET_ADD_PRODUCT_ACTION',
};
function reducer(state, { type, payload }) {
    switch (type) {
        case exports.actionTypes.SET_ARTICLE:
            return Object.assign({}, state, { article: payload });
        case exports.actionTypes.FETCH_ANALOG:
            return Object.assign({}, state, { analog: false, fetchAnalog: true, fetchAnalogError: false, fetchProjectsFailure: false, productAdded: false, addProductFailure: false, addRequest: false });
        case exports.actionTypes.SET_ANALOG:
            return Object.assign({}, state, { analog: payload, fetchAnalog: false });
        case exports.actionTypes.FETCH_ANALOG_FAILURE:
            return Object.assign({}, state, { analog: false, fetchAnalog: false, fetchAnalogError: payload });
        case exports.actionTypes.FETCH_PROJECTS:
            return Object.assign({}, state, { fetchProjects: true, fetchProjectsFailure: false });
        case exports.actionTypes.SET_PROJECTS:
            return Object.assign({}, state, { projects: payload.filter(el => {
                    el.count = 1;
                    return el.status.slug === 'in_work';
                }), fetchProjectsFailure: false, fetchProjects: false });
        case exports.actionTypes.FETCH_PROJECTS_FAILURE:
            return Object.assign({}, state, { projects: [], fetchProjectsFailure: payload, fetchProjects: false });
        case exports.actionTypes.SET_SELECTED_PROJECTS:
            return Object.assign({}, state, { selectedProjects: payload });
        case exports.actionTypes.SET_CURRENT_PRODUCT:
            return Object.assign({}, state, { product: payload });
        case exports.actionTypes.ADD_PRODUCT_REQUEST:
            return Object.assign({}, state, { addRequest: true, addProductFailure: false });
        case exports.actionTypes.ADD_PRODUCT_FAILURE:
            return Object.assign({}, state, { addProductFailure: payload });
        case exports.actionTypes.ADD_PRODUCT_SUCCESS:
            return Object.assign({}, state, { addRequest: false, productAdded: true });
        case exports.actionTypes.RESET_ADD_PRODUCT_ACTION:
            return Object.assign({}, state, { productAdded: false, addProductFailure: false, addRequest: false });
        default:
            return state;
    }
}
exports.reducer = reducer;
