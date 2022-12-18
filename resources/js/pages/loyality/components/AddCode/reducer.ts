export const initialState = {
    step: 1,
    code: "",
    isLoading: false,
    error: false
};

export const actionTypes = {
    SET_CODE: "SET_CODE",
    FETCH: "FETCH",
    FETCH_SUCCESS: "FETCH_SUCCESS",
    FETCH_FAILURE: "FATCH_FAILURE"
};

export const reducer = (state, { type, payload }: any) => {
    switch (type) {
        case actionTypes.SET_CODE:
            return { ...state, code: payload };
        case actionTypes.FETCH:
            return { ...state, error: false, isLoading: true };
        case actionTypes.FETCH_SUCCESS:
            return { ...state, step: 2, error: false, isLoading: false };
        case actionTypes.FETCH_FAILURE:
            return { ...state, error: payload, isLoading: false };
        default:
            return state;
    }
};
