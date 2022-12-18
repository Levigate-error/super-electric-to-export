export function reducer(state, { type, payload }: any) {
    switch (type) {
        case 'fetch':
            return { ...state, isLoading: true };
        case 'select-category':
            return { ...state, selectedCategory: payload };
        case 'set-categories':
            return { ...state, categories: payload, isLoading: false };
        case 'set-project-categories':
            return { ...state, projectCategories: payload };
        case 'add-category':
            return { ...state, projectCategories: payload, isLoading: false };
        default:
            return state;
    }
}
