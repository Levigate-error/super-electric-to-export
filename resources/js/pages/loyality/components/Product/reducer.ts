export const actionTypes = {
    FAVORITES_REQUEST: 'FAVORITES_REQUEST',
    ADD_TO_FAVORITES: 'ADD_TO_FAVORITES',
    REMOVE_FROM_FAVORITES: 'REMOVE_FROM_FAVORITES',
    IMG_ERROR: 'IMG_ERROR',
};
export function reducer(state, action) {
    switch (action.type) {
        case actionTypes.FAVORITES_REQUEST:
            return { ...state, isLoading: true };
        case actionTypes.ADD_TO_FAVORITES:
            return { ...state, isFavorites: true, isLoading: false };
        case actionTypes.REMOVE_FROM_FAVORITES:
            return { ...state, isFavorites: false, isLoading: false };
        case actionTypes.IMG_ERROR:
            return { ...state, imgError: true };
        default:
            return state;
    }
}
