export function reducer(state, action) {
    switch (action.type) {
        case "fetch":
            return { ...state, fetch: true };
        case "imgLoadingError":
            return { ...state, imgError: true };
        case "changeAmount":
            return { ...state, amount: action.payload, fetch: true };
        default:
            return state;
    }
}
