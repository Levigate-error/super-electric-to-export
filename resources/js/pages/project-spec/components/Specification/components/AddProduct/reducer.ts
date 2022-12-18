export function reducer(state, { type, payload }: any) {
    switch (type) {
        case "fetch":
            return { ...state, isLoading: true };
        case "open-search":
            return { ...state, dropdownIsVisible: true };
        case "hide-search":
            return { ...state, dropdownIsVisible: false };
        case "set-values":
            return { ...state, values: payload };
        default:
            return state;
    }
}
