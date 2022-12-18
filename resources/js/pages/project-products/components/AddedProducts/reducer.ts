export function reducer(state, { type, payload }: any) {
    switch (type) {
        case "fetch":
            return { ...state, isLoading: true, selectedDivision: null };
        case "select-division":
            return { ...state, selectedDivision: payload };
        case "set-divisions":
            return { ...state, divisions: payload, isLoading: false };

        default:
            return state;
    }
}
