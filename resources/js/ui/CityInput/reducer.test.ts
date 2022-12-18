import { initialState, reducer, actionTypes } from "./reducer";

describe("CityInput reducer", () => {
    it("should return the initial state", () => {
        expect(reducer(initialState, {})).toEqual(initialState);
    });

    it(`should handle ${actionTypes.FETCH_LIST}`, () => {
        const action = { type: actionTypes.FETCH_LIST };
        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            isLoading: true,
            error: false
        });
    });

    it(`should handle ${actionTypes.SET_VALUE}`, () => {
        const newValue = "qwerty";
        const action = { type: actionTypes.SET_VALUE, payload: newValue };
        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            value: newValue
        });
    });

    it(`should handle ${actionTypes.FETCH_LIST}`, () => {
        const action = { type: actionTypes.FETCH_LIST };
        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            isLoading: true,
            error: false
        });
    });

    it(`should handle ${actionTypes.FETCH_SUCCESS}`, () => {
        const newList = [1, 2, 3];

        const action = { type: actionTypes.FETCH_SUCCESS, payload: newList };
        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            isLoading: false,
            list: [1, 2, 3]
        });
    });

    it(`should handle ${actionTypes.FETCH_FAILURE}`, () => {
        const error = "qwerty";

        const action = { type: actionTypes.FETCH_FAILURE, payload: error };
        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            isLoading: false,
            error: "qwerty"
        });
    });

    it(`should handle ${actionTypes.SELECT_ITEM}`, () => {
        const newItem = { id: 0, title: "qwerty" };

        const action = { type: actionTypes.SELECT_ITEM, payload: newItem };
        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            selectedCity: 0,
            value: "qwerty"
        });
    });
});
