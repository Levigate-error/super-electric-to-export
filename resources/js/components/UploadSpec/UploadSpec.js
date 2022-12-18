"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const reducer_1 = require("./reducer");
const Modal_1 = require("../../ui/Modal");
const api_1 = require("./api");
const antd_1 = require("antd");
const Projects_1 = require("./elements/Projects");
const Upload_1 = require("./elements/Upload");
const initialState = {
    errors: [],
    validateErrors: [],
    selectProjectOpen: false,
    projectsChanges: [],
    isFetch: false,
    projects: [],
    selectedProjects: [],
    file: null,
    exampleSpec: false,
    changesApply: false,
};
const UploadSpec = ({ isOpen, onClose }) => {
    const [{ errors, validateErrors, selectProjectOpen, isFetch, projects, selectedProjects, file, projectsChanges, exampleSpec, changesApply, }, dispatch,] = React.useReducer(reducer_1.reducer, initialState);
    React.useEffect(() => {
        api_1.downloadSpecExample()
            .then(response => {
            dispatch({
                type: 'set-example-spec',
                payload: response.data.url,
            });
        })
            .catch(err => {
            dispatch({
                type: 'set-example-spec',
                payload: '#',
            });
        });
    }, []);
    const handleUploadSpec = event => {
        const file = event.target.files[0];
        dispatch({ type: 'start-validate' });
        api_1.validateSpec({ file })
            .then(response => {
            api_1.getProjects().then(resp => {
                dispatch({
                    type: 'validate-sucsess',
                    payload: { projects: resp.data.projects, file },
                });
            });
        })
            .catch(function (err) {
            if (Array.isArray(err.response.data)) {
                dispatch({
                    type: 'validate-error',
                    payload: Object.values(err.response.data),
                });
            }
            else {
                dispatch({
                    type: 'format-error',
                    payload: Object.values(err.response.data.errors),
                });
            }
        });
    };
    const handleCloseModal = () => {
        if (changesApply) {
            dispatch({ type: 'close-modal' });
            onClose();
            location.reload();
        }
        dispatch({ type: 'close-modal' });
        onClose();
    };
    const handleChangeCheckbox = (el, value) => {
        const newSelectedProjects = value
            ? [...selectedProjects, el]
            : selectedProjects.filter(proj => proj.id !== el.id);
        dispatch({
            type: 'set-selected-projects',
            payload: newSelectedProjects,
        });
    };
    const handleCreateProject = () => {
        api_1.createProject(file)
            .then(response => {
            document.location.href = window.location.origin + '/project/update/' + response.data.id;
        })
            .catch(error => { });
    };
    const openNotificationWithIcon = (type, message, description) => {
        antd_1.notification[type]({
            message,
            description,
            duration: 0,
        });
    };
    const handleCompare = () => {
        if (selectedProjects.length) {
            dispatch({ type: 'projects-changes-request' });
            selectedProjects.forEach((project, i) => {
                api_1.compareProject(file, project.id)
                    .then(response => {
                    dispatch({
                        type: 'set-projects-changes',
                        payload: {
                            project,
                            changes: response.data,
                            apply: false,
                        },
                    });
                })
                    .catch(error => { });
                selectedProjects.length === i + 1 && dispatch({ type: 'fetch-success' });
            });
        }
        else {
            openNotificationWithIcon('error', 'Не выбраны проекты', 'Для загрузки спецификации выберите проекты из списка.');
        }
    };
    const formatErrors = [];
    errors.forEach(type => {
        type.forEach(error => {
            formatErrors.push(error);
        });
    });
    return (React.createElement(Modal_1.default, { isOpen: isOpen, onClose: handleCloseModal, children: React.createElement(React.Fragment, null, selectProjectOpen ? (React.createElement(Projects_1.default, { createFromFile: handleCreateProject, changeCheckbox: handleChangeCheckbox, projects: projects, selectedProjects: selectedProjects, compareProjects: handleCompare, projectsChanges: projectsChanges, isFetch: isFetch })) : (React.createElement(Upload_1.default, { formatErrors: formatErrors, validateErrors: validateErrors, uploadSpec: handleUploadSpec, validateFetch: isFetch, exampleSpec: exampleSpec }))) }));
};
exports.default = UploadSpec;
