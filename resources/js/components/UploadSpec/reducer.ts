export function reducer(state, { type, payload }: any) {
    switch (type) {
        case 'set-example-spec':
            return {
                ...state,
                exampleSpec: payload,
            };
        case 'start-validate':
            return {
                ...state,
                selectProjectOpen: false,
                errors: [],
                validateErrors: [],
                isFetch: true,
            };
        case 'validate-sucsess':
            return {
                ...state,
                selectProjectOpen: true,
                isFetch: false,
                projects: payload.projects,
                file: payload.file,
            };
        case 'format-error':
            return {
                ...state,
                selectProjectOpen: false,
                errors: payload,
                isFetch: false,
            };
        case 'validate-error':
            return {
                ...state,
                selectProjectOpen: false,
                validateErrors: payload,
                isFetch: false,
            };
        case 'close-modal':
            return {
                ...state,
                selectProjectOpen: false,
                errors: [],
                validateErrors: [],
                isFetch: false,
                projects: [],
                selectedProjects: [],
                file: null,
                projectsChanges: [],
                changesApply: false,
            };
        case 'set-selected-projects':
            return { ...state, selectedProjects: payload, isFetch: false };
        case 'projects-changes-request':
            return { ...state, isFetch: true };
        case 'set-projects-changes':
            return {
                ...state,
                projectsChanges: [...state.projectsChanges, payload],
                changesApply: true,
            };
        case 'fetch-success':
            return { ...state, isFetch: false };
        default:
            return state;
    }
}
