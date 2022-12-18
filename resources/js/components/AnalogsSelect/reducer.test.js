"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const reducer_1 = require("./reducer");
const testPayload = 'TEST';
describe('analogSelect reducer', () => {
    it('should return the initial state', () => {
        expect(reducer_1.reducer(reducer_1.initialState, {})).toEqual(reducer_1.initialState);
    });
    it(`should handle ${reducer_1.actionTypes.SET_ARTICLE}`, () => {
        const action = { type: reducer_1.actionTypes.SET_ARTICLE, payload: testPayload };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { article: testPayload }));
    });
    it(`should handle ${reducer_1.actionTypes.FETCH_ANALOG}`, () => {
        const action = { type: reducer_1.actionTypes.FETCH_ANALOG };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { analog: false, fetchAnalog: true, fetchAnalogError: false, fetchProjectsFailure: false, productAdded: false, addProductFailure: false, addRequest: false }));
    });
    it(`should handle ${reducer_1.actionTypes.SET_ANALOG}`, () => {
        const action = { type: reducer_1.actionTypes.SET_ANALOG, payload: testPayload };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { analog: testPayload, fetchAnalog: false }));
    });
    it(`should handle ${reducer_1.actionTypes.FETCH_ANALOG_FAILURE}`, () => {
        const action = { type: reducer_1.actionTypes.FETCH_ANALOG_FAILURE, payload: testPayload };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { analog: false, fetchAnalog: false, fetchAnalogError: testPayload }));
    });
    it(`should handle ${reducer_1.actionTypes.FETCH_PROJECTS}`, () => {
        const action = { type: reducer_1.actionTypes.FETCH_PROJECTS };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { fetchProjects: true, fetchProjectsFailure: false }));
    });
    it(`should handle ${reducer_1.actionTypes.SET_PROJECTS}`, () => {
        const newProjects = [
            { id: 1, status: { slug: 'in_work' } },
            { id: 2, status: { slug: 'not_in_work' } },
            { id: 3, status: { slug: 'in_work' } },
        ];
        const action = { type: reducer_1.actionTypes.SET_PROJECTS, payload: newProjects };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { projects: [
                { id: 1, count: 1, status: { slug: 'in_work' } },
                { id: 3, count: 1, status: { slug: 'in_work' } },
            ], fetchProjectsFailure: false, fetchProjects: false }));
    });
    it(`should handle ${reducer_1.actionTypes.FETCH_PROJECTS_FAILURE}`, () => {
        const action = { type: reducer_1.actionTypes.FETCH_PROJECTS_FAILURE, payload: testPayload };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { projects: [], fetchProjectsFailure: testPayload, fetchProjects: false }));
    });
    it(`should handle ${reducer_1.actionTypes.SET_SELECTED_PROJECTS}`, () => {
        const action = { type: reducer_1.actionTypes.SET_SELECTED_PROJECTS, payload: testPayload };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { selectedProjects: testPayload }));
    });
    it(`should handle ${reducer_1.actionTypes.SET_CURRENT_PRODUCT}`, () => {
        const action = { type: reducer_1.actionTypes.SET_CURRENT_PRODUCT, payload: testPayload };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { product: testPayload }));
    });
    it(`should handle ${reducer_1.actionTypes.ADD_PRODUCT_REQUEST}`, () => {
        const action = { type: reducer_1.actionTypes.ADD_PRODUCT_REQUEST };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { addRequest: true, addProductFailure: false }));
    });
    it(`should handle ${reducer_1.actionTypes.ADD_PRODUCT_FAILURE}`, () => {
        const action = { type: reducer_1.actionTypes.ADD_PRODUCT_FAILURE, payload: testPayload };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { addProductFailure: testPayload }));
    });
    it(`should handle ${reducer_1.actionTypes.ADD_PRODUCT_SUCCESS}`, () => {
        const action = { type: reducer_1.actionTypes.ADD_PRODUCT_SUCCESS };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { addRequest: false, productAdded: true }));
    });
    it(`should handle ${reducer_1.actionTypes.RESET_ADD_PRODUCT_ACTION}`, () => {
        const action = { type: reducer_1.actionTypes.RESET_ADD_PRODUCT_ACTION };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { productAdded: false, addProductFailure: false, addRequest: false }));
    });
});
