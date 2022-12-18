import { reducer, initialState, actionTypes } from "./reducer";

describe("team reducer", () => {
    it("should return the initial state", () => {
        expect(reducer(initialState, {})).toEqual(initialState);
    });

    it(`should handle ${actionTypes.REGISTER}`, () => {
        const action = { type: actionTypes.REGISTER };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            isLoading: true,
            error: false,
            codeError: false
        });
    });

    it(`should handle ${actionTypes.SET_VIN}`, () => {
        const newVIN = "qwerty";
        const action = { type: actionTypes.SET_VIN, payload: newVIN };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            vin: newVIN
        });
    });

    it(`should handle ${actionTypes.SET_STEP}`, () => {
        const nextSTEP = 2;
        const action = { type: actionTypes.SET_STEP, payload: nextSTEP };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            step: nextSTEP
        });
    });

    it(`should handle ${actionTypes.CODE_ERROR}`, () => {
        const ERR = "error";
        const action = { type: actionTypes.CODE_ERROR, payload: ERR };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            isLoading: false,
            codeError: ERR
        });
    });

    it(`should handle ${actionTypes.FIELD_ERROR}`, () => {
        const ERR = "error";
        const action = { type: actionTypes.FIELD_ERROR, payload: ERR };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            isLoading: false,
            error: ERR
        });
    });

    it(`should handle ${actionTypes.LOYALTY_ID_ERROR}`, () => {
        const ERR = "error";
        const action = { type: actionTypes.LOYALTY_ID_ERROR, payload: ERR };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            isLoading: false,
            loyaltyError: ERR
        });
    });
});
