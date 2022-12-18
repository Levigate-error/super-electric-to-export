export const initialState = {
    step: 1,
    vin: "",
    isLoading: false,
    codeError: false,
    error: false,
    loyaltyError: false
};

export const actionTypes = {
    SET_STEP: "SET_STEP",
    SET_VIN: "SET_VIN",
    REGISTER: "REGISTER",
    CODE_ERROR: "CODE_ERROR",
    FIELD_ERROR: "FIELD_ERROR",
    LOYALTY_ID_ERROR: "LOYALTY_ID_ERROR"
};
// TODO: loyalty_id error
export function reducer(state, { type, payload }: any) {
    switch (type) {
        case actionTypes.REGISTER:
            return {
                ...state,
                isLoading: true,
                error: false,
                codeError: false,
                loyaltyError: false
            };
        case actionTypes.SET_VIN:
            return { ...state, vin: payload };
        case actionTypes.SET_STEP:
            return { ...state, step: payload };
        case actionTypes.FIELD_ERROR:
            return { ...state, isLoading: false, error: payload };
        case actionTypes.CODE_ERROR:
            return { ...state, isLoading: false, codeError: payload };
        case actionTypes.LOYALTY_ID_ERROR:
            return { ...state, isLoading: false, loyaltyError: payload };
        default:
            return state;
    }
}
