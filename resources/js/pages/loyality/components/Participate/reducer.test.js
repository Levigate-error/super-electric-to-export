"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const reducer_1 = require("./reducer");
describe("team reducer", () => {
    it("should return the initial state", () => {
        expect(reducer_1.reducer(reducer_1.initialState, {})).toEqual(reducer_1.initialState);
    });
    it(`should handle ${reducer_1.actionTypes.REGISTER}`, () => {
        const action = { type: reducer_1.actionTypes.REGISTER };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { isLoading: true, error: false, codeError: false }));
    });
    it(`should handle ${reducer_1.actionTypes.SET_VIN}`, () => {
        const newVIN = "qwerty";
        const action = { type: reducer_1.actionTypes.SET_VIN, payload: newVIN };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { vin: newVIN }));
    });
    it(`should handle ${reducer_1.actionTypes.SET_STEP}`, () => {
        const nextSTEP = 2;
        const action = { type: reducer_1.actionTypes.SET_STEP, payload: nextSTEP };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { step: nextSTEP }));
    });
    it(`should handle ${reducer_1.actionTypes.CODE_ERROR}`, () => {
        const ERR = "error";
        const action = { type: reducer_1.actionTypes.CODE_ERROR, payload: ERR };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { isLoading: false, codeError: ERR }));
    });
    it(`should handle ${reducer_1.actionTypes.FIELD_ERROR}`, () => {
        const ERR = "error";
        const action = { type: reducer_1.actionTypes.FIELD_ERROR, payload: ERR };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { isLoading: false, error: ERR }));
    });
    it(`should handle ${reducer_1.actionTypes.LOYALTY_ID_ERROR}`, () => {
        const ERR = "error";
        const action = { type: reducer_1.actionTypes.LOYALTY_ID_ERROR, payload: ERR };
        expect(reducer_1.reducer(reducer_1.initialState, action)).toEqual(Object.assign({}, reducer_1.initialState, { isLoading: false, loyaltyError: ERR }));
    });
});
