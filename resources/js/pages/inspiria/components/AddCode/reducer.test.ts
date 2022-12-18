import { reducer, initialState, actionTypes } from "./reducer";

describe("team reducer", () => {
    it("should return the initial state", () => {
        expect(reducer(initialState, {})).toEqual(initialState);
    });

    it(`should handle ${actionTypes.FETCH}`, () => {
        const action = { type: actionTypes.FETCH };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            isLoading: true,
            error: false
        });
    });

    it(`should handle ${actionTypes.SET_CODE}`, () => {
        const newCode = "qwerty";
        const action = { type: actionTypes.SET_CODE, payload: newCode };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            code: newCode
        });
    });

    it(`should handle ${actionTypes.FETCH_SUCCESS}`, () => {
        const action = { type: actionTypes.FETCH_SUCCESS };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            step: 2,
            isLoading: false,
            error: false
        });
    });

    it(`should handle ${actionTypes.FETCH_FAILURE}`, () => {
        const err = "qwerty";
        const action = { type: actionTypes.FETCH_FAILURE, payload: err };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            isLoading: false,
            error: err
        });
    });
});
