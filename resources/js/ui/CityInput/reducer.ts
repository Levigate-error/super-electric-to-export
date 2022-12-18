export const initialState = {
    value: "",
    list: [],
    isLoading: false,
    selectedCity: null,
    error: false
};

export const actionTypes = {
    SET_VALUE: "SET_VALUE",
    FETCH_LIST: "FETCH_LIST",
    FETCH_FAILURE: "FETCH_FAILURE",
    FETCH_SUCCESS: "FETCH_SUCCESS",
    SELECT_ITEM: "SELECT_ITEM",
    REMOVE_SELECTED: "REMOVE_SELECTED"
};

export const reducer = (state = initialState, { type, payload }: any) => {
    switch (type) {
        case actionTypes.SET_VALUE:
            return { ...state, value: payload };
        case actionTypes.FETCH_LIST:
            return { ...state, isLoading: true, error: false };
        case actionTypes.FETCH_SUCCESS:
            return { ...state, list: payload, isLoading: false };
        case actionTypes.FETCH_FAILURE:
            return { ...state, isLoading: false, error: payload };
        case actionTypes.SELECT_ITEM:
            return {
                ...state,
                selectedCity: payload.id,
                value: `${payload.title}`
            };
        default:
            return state;
    }
};
