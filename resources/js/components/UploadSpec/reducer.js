"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
function reducer(state, { type, payload }) {
    switch (type) {
        case 'set-example-spec':
            return Object.assign({}, state, { exampleSpec: payload });
        case 'start-validate':
            return Object.assign({}, state, { selectProjectOpen: false, errors: [], validateErrors: [], isFetch: true });
        case 'validate-sucsess':
            return Object.assign({}, state, { selectProjectOpen: true, isFetch: false, projects: payload.projects, file: payload.file });
        case 'format-error':
            return Object.assign({}, state, { selectProjectOpen: false, errors: payload, isFetch: false });
        case 'validate-error':
            return Object.assign({}, state, { selectProjectOpen: false, validateErrors: payload, isFetch: false });
        case 'close-modal':
            return Object.assign({}, state, { selectProjectOpen: false, errors: [], validateErrors: [], isFetch: false, projects: [], selectedProjects: [], file: null, projectsChanges: [], changesApply: false });
        case 'set-selected-projects':
            return Object.assign({}, state, { selectedProjects: payload, isFetch: false });
        case 'projects-changes-request':
            return Object.assign({}, state, { isFetch: true });
        case 'set-projects-changes':
            return Object.assign({}, state, { projectsChanges: [...state.projectsChanges, payload], changesApply: true });
        case 'fetch-success':
            return Object.assign({}, state, { isFetch: false });
        default:
            return state;
    }
}
exports.reducer = reducer;
