export const initialState = {
    currentPage: 0,
    userAnswers: [],
    publishRequest: false,
    publishError: false,
    resultData: false,
    inProgress: false,
};

export const actionTypes = {
    START_TEST: 'START_TEST',
    SET_PAGE: 'SET_PAGE',
    ADD_ANSWERS: 'ADD_ANSWERS',
    PUBLISH_REQUEST: 'PUBLISH_REQUEST',
    PUBLISH_FAILURE: 'PUBLISH_FAILURE',
    PUBLISH_SUCCESS: 'PUBLISH_SUCCESS',
    SET_RESULT: 'SET_RESULT',
};

export function reducer(state, { type, payload }: any) {
    switch (type) {
        case actionTypes.START_TEST:
            return { ...state, inProgress: true };
        case actionTypes.SET_PAGE:
            return { ...state, currentPage: payload };
        case actionTypes.ADD_ANSWERS:
            return { ...state, userAnswers: [...state.userAnswers, payload] };
        case actionTypes.PUBLISH_REQUEST:
            return { ...state, publishRequest: true, publishError: false };
        case actionTypes.PUBLISH_FAILURE:
            return { ...state, publishRequest: false, publishError: payload };
        case actionTypes.PUBLISH_SUCCESS:
            return { ...state, publishRequest: false, resultData: payload };
        case actionTypes.SET_RESULT:
            return { ...state, resultData: payload };
        default:
            return state;
    }
}
