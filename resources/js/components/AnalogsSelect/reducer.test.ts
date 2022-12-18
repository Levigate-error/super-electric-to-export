import { reducer, initialState, actionTypes } from './reducer';

const testPayload = 'TEST';

describe('analogSelect reducer', () => {
    it('should return the initial state', () => {
        expect(reducer(initialState, {})).toEqual(initialState);
    });

    it(`should handle ${actionTypes.SET_ARTICLE}`, () => {
        const action = { type: actionTypes.SET_ARTICLE, payload: testPayload };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            article: testPayload,
        });
    });

    it(`should handle ${actionTypes.FETCH_ANALOG}`, () => {
        const action = { type: actionTypes.FETCH_ANALOG };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            analog: false,
            fetchAnalog: true,
            fetchAnalogError: false,
            fetchProjectsFailure: false,
            productAdded: false,
            addProductFailure: false,
            addRequest: false,
        });
    });

    it(`should handle ${actionTypes.SET_ANALOG}`, () => {
        const action = { type: actionTypes.SET_ANALOG, payload: testPayload };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            analog: testPayload,
            fetchAnalog: false,
        });
    });

    it(`should handle ${actionTypes.FETCH_ANALOG_FAILURE}`, () => {
        const action = { type: actionTypes.FETCH_ANALOG_FAILURE, payload: testPayload };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            analog: false,
            fetchAnalog: false,
            fetchAnalogError: testPayload,
        });
    });

    it(`should handle ${actionTypes.FETCH_PROJECTS}`, () => {
        const action = { type: actionTypes.FETCH_PROJECTS };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            fetchProjects: true,
            fetchProjectsFailure: false,
        });
    });

    it(`should handle ${actionTypes.SET_PROJECTS}`, () => {
        const newProjects = [
            { id: 1, status: { slug: 'in_work' } },
            { id: 2, status: { slug: 'not_in_work' } },
            { id: 3, status: { slug: 'in_work' } },
        ];
        const action = { type: actionTypes.SET_PROJECTS, payload: newProjects };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            projects: [
                { id: 1, count: 1, status: { slug: 'in_work' } },
                { id: 3, count: 1, status: { slug: 'in_work' } },
            ],
            fetchProjectsFailure: false,
            fetchProjects: false,
        });
    });

    it(`should handle ${actionTypes.FETCH_PROJECTS_FAILURE}`, () => {
        const action = { type: actionTypes.FETCH_PROJECTS_FAILURE, payload: testPayload };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            projects: [],
            fetchProjectsFailure: testPayload,
            fetchProjects: false,
        });
    });

    it(`should handle ${actionTypes.SET_SELECTED_PROJECTS}`, () => {
        const action = { type: actionTypes.SET_SELECTED_PROJECTS, payload: testPayload };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            selectedProjects: testPayload,
        });
    });

    it(`should handle ${actionTypes.SET_CURRENT_PRODUCT}`, () => {
        const action = { type: actionTypes.SET_CURRENT_PRODUCT, payload: testPayload };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            product: testPayload,
        });
    });

    it(`should handle ${actionTypes.ADD_PRODUCT_REQUEST}`, () => {
        const action = { type: actionTypes.ADD_PRODUCT_REQUEST };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            addRequest: true,
            addProductFailure: false,
        });
    });

    it(`should handle ${actionTypes.ADD_PRODUCT_FAILURE}`, () => {
        const action = { type: actionTypes.ADD_PRODUCT_FAILURE, payload: testPayload };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            addProductFailure: testPayload,
        });
    });

    it(`should handle ${actionTypes.ADD_PRODUCT_SUCCESS}`, () => {
        const action = { type: actionTypes.ADD_PRODUCT_SUCCESS };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            addRequest: false,
            productAdded: true,
        });
    });

    it(`should handle ${actionTypes.RESET_ADD_PRODUCT_ACTION}`, () => {
        const action = { type: actionTypes.RESET_ADD_PRODUCT_ACTION };

        expect(reducer(initialState, action)).toEqual({
            ...initialState,
            productAdded: false,
            addProductFailure: false,
            addRequest: false,
        });
    });
});
