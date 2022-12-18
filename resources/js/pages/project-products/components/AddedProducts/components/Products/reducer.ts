export function reducer(state, { type, payload }: any) {
    switch (type) {
        case "fetch":
            return { ...state, isLoading: true, products: null };
        case "select-products":
            return { ...state, products: payload, isLoading: false };
        case "change-display-format":
            return { ...state, showAsRows: !state.showAsRows };

        default:
            return state;
    }
}
