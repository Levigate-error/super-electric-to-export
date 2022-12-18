"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const reducer_1 = require("./reducer");
describe("CityInput reducer", () => {
    it("should return the initial state", () => {
        expect(reducer_1.reducer(reducer_1.initialState, {})).toEqual(reducer_1.initialState);
    });
    it(`should handle ${reducer_1.actionTypes.FETCH_LIST}`, () => {
        const action = { type: reducer_1.actionTypes.FETCH_LIST };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { isLoading: true, error: false }));
    });
    it(`should handle ${reducer_1.actionTypes.SET_VALUE}`, () => {
        const newValue = "qwerty";
        const action = { type: reducer_1.actionTypes.SET_VALUE, payload: newValue };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { value: newValue }));
    });
    it(`should handle ${reducer_1.actionTypes.FETCH_LIST}`, () => {
        const action = { type: reducer_1.actionTypes.FETCH_LIST };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { isLoading: true, error: false }));
    });
    it(`should handle ${reducer_1.actionTypes.FETCH_SUCCESS}`, () => {
        const newList = [1, 2, 3];
        const action = { type: reducer_1.actionTypes.FETCH_SUCCESS, payload: newList };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { isLoading: false, list: [1, 2, 3] }));
    });
    it(`should handle ${reducer_1.actionTypes.FETCH_FAILURE}`, () => {
        const error = "qwerty";
        const action = { type: reducer_1.actionTypes.FETCH_FAILURE, payload: error };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { isLoading: false, error: "qwerty" }));
    });
    it(`should handle ${reducer_1.actionTypes.SELECT_ITEM}`, () => {
        const newItem = { id: 0, title: "qwerty" };
        const action = { type: reducer_1.actionTypes.SELECT_ITEM, payload: newItem };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { selectedCity: 0, value: "qwerty" }));
    });
});
