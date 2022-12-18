export const initialState = {
    article: '',
    analog: false,
    fetchAnalog: false,
    fetchAnalogError: false,
    fetchProjects: false,
    fetchProjectsFailure: false,
    projects: [],
    selectedProjects: [],
    product: 0,
    productAdded: false,
    addProductFailure: false,
    addRequest: false,
};

export const actionTypes = {
    SET_ARTICLE: 'SET_ARTICLE',
    FETCH_ANALOG: 'FETCH_ANALOG',
    SET_ANALOG: 'SET_ANALOG',
    FETCH_ANALOG_FAILURE: 'FETCH_ANALOG_FAILURE',
    FETCH_PROJECTS: 'FETCH_PROJECTS',
    SET_PROJECTS: 'SET_PROJECTS',
    FETCH_PROJECTS_FAILURE: 'FETCH_PROJECTS_FAILURE',
    SET_SELECTED_PROJECTS: 'SET_SELECTED_PROJECTS',
    SET_CURRENT_PRODUCT: 'SET_CURRENT_PRODUCT',
    ADD_PRODUCT_REQUEST: 'ADD_PRODUCT_REQUEST',
    ADD_PRODUCT_FAILURE: 'ADD_PRODUCT_FAILURE',
    ADD_PRODUCT_SUCCESS: 'ADD_PRODUCT_SUCCESS',
    RESET_ADD_PRODUCT_ACTION: 'RESET_ADD_PRODUCT_ACTION',
};

export function reducer(state, { type, payload }: any) {
    switch (type) {
        case actionTypes.SET_ARTICLE:
            return { ...state, article: payload };
        case actionTypes.FETCH_ANALOG:
            return {
                ...state,
                analog: false,
                fetchAnalog: true,
                fetchAnalogError: false,
                fetchProjectsFailure: false,
                productAdded: false,
                addProductFailure: false,
                addRequest: false,
            };
        case actionTypes.SET_ANALOG:
            return {
                ...state,
                analog: payload,
                fetchAnalog: false,
            };
        case actionTypes.FETCH_ANALOG_FAILURE:
            return {
                ...state,
                analog: false,
                fetchAnalog: false,
                fetchAnalogError: payload,
            };

        case actionTypes.FETCH_PROJECTS:
            return {
                ...state,
                fetchProjects: true,
                fetchProjectsFailure: false,
            };
        case actionTypes.SET_PROJECTS:
            return {
                ...state,
                projects: payload.filter(el => {
                    el.count = 1;
                    return el.status.slug === 'in_work';
                }),
                fetchProjectsFailure: false,
                fetchProjects: false,
            };

        case actionTypes.FETCH_PROJECTS_FAILURE:
            return {
                ...state,
                projects: [],
                fetchProjectsFailure: payload,
                fetchProjects: false,
            };
        case actionTypes.SET_SELECTED_PROJECTS:
            return { ...state, selectedProjects: payload };
        case actionTypes.SET_CURRENT_PRODUCT:
            return { ...state, product: payload };
        case actionTypes.ADD_PRODUCT_REQUEST:
            return { ...state, addRequest: true, addProductFailure: false };
        case actionTypes.ADD_PRODUCT_FAILURE:
            return { ...state, addProductFailure: payload };
        case actionTypes.ADD_PRODUCT_SUCCESS:
            return { ...state, addRequest: false, productAdded: true };
        case actionTypes.RESET_ADD_PRODUCT_ACTION:
            return {
                ...state,
                productAdded: false,
                addProductFailure: false,
                addRequest: false,
            };
        default:
            return state;
    }
}
