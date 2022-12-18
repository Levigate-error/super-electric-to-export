export const initalState = {
    fetch: false,
    email: "",
    emailError: false,
    error: false,
    success: false
};

export const actionTypes = {
    RESET_REQUEST: "RESET_REQUEST",
    SET_EMAIL: "SET_EMAIL",
    SET_EMAIL_ERROR: "SET_EMAIL_ERROR",
    RESET_FAILURE: "RESET_FAILURE",
    RESET_SUCCESS: "RESET_SUCCESS"
};

export function reducer(state, { type, payload }: any) {
    switch (type) {
        case actionTypes.SET_EMAIL:
            return {
                ...state,
                email: payload,
                error: false,
                emailError: false
            };
        case actionTypes.SET_EMAIL_ERROR:
            return { ...state, emailError: payload };
        case actionTypes.RESET_REQUEST:
            return { ...state, fetch: true, error: false, success: false };
        case actionTypes.RESET_FAILURE:
            return { ...state, error: payload, fetch: false };
        case actionTypes.RESET_SUCCESS:
            return { ...state, fetch: false, success: true };
        default:
            return state;
    }
}
