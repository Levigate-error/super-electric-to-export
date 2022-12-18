export const initialState = {
    isLoading: true,
    news: [],
    currentNews: 0,
    error: false,
};

export const actionTypes = {
    FETCH_NEWS: 'FETCH_NEWS',
    FETCH_NEWS_SUCCESS: 'FETCH_NEWS_SUCCESS',
    FETCH_NEWS_FAILURE: 'FETCH_NEWS_FAILURE',
    SET_NEWS: 'SET_NEWS',
    SET_CURRENT_NEWS: 'SET_CURRENT_NEWS',
};

export function reducer(state, { type, payload }: any): any {
    switch (type) {
        case actionTypes.FETCH_NEWS:
            return { ...state, isLoading: true };
        case actionTypes.FETCH_NEWS_SUCCESS:
            return {
                ...state,
                isLoading: false,
                news: payload,
                currentNews: 0,
                prevAvailable: false,
                nextAvailable: true,
            };
        case actionTypes.FETCH_NEWS_FAILURE:
            return { ...state, isLoading: false, error: true };
        case actionTypes.SET_NEWS:
            return { ...state, currentNews: payload };
        case actionTypes.SET_CURRENT_NEWS:
            return {
                ...state,
                currentNews: payload,
            };
        default:
            return state;
    }
}
