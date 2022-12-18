"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const reducer_1 = require("./reducer");
describe("team reducer", () => {
    it("should return the initial state", () => {
        expect(reducer_1.reducer(reducer_1.initialState, {})).toEqual(reducer_1.initialState);
    });
    it(`should handle ${reducer_1.actionTypes.FETCH}`, () => {
        const action = { type: reducer_1.actionTypes.FETCH };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { isLoading: true, error: false }));
    });
    it(`should handle ${reducer_1.actionTypes.SET_CODE}`, () => {
        const newCode = "qwerty";
        const action = { type: reducer_1.actionTypes.SET_CODE, payload: newCode };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { code: newCode }));
    });
    it(`should handle ${reducer_1.actionTypes.FETCH_SUCCESS}`, () => {
        const action = { type: reducer_1.actionTypes.FETCH_SUCCESS };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { step: 2, isLoading: false, error: false }));
    });
    it(`should handle ${reducer_1.actionTypes.FETCH_FAILURE}`, () => {
        const err = "qwerty";
        const action = { type: reducer_1.actionTypes.FETCH_FAILURE, payload: err };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { isLoading: false, error: err }));
    });
});
