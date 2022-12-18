import * as React from 'react';
import { reducer } from './reducer';
import Modal from '../../ui/Modal';
import { validateSpec, getProjects, createProject, compareProject, downloadSpecExample } from './api';
import { notification } from 'antd';

import Projects from './elements/Projects';
import Uplaod from './elements/Upload';

interface IUploadSpec {
    isOpen: boolean;
    onClose: () => void;
}

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

const UploadSpec = ({ isOpen, onClose }: IUploadSpec) => {
    const [
        {
            errors,
            validateErrors,
            selectProjectOpen,
            isFetch,
            projects,
            selectedProjects,
            file,
            projectsChanges,
            exampleSpec,
            changesApply,
        },
        dispatch,
    ] = React.useReducer(reducer, initialState);

    React.useEffect(() => {
        downloadSpecExample()
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
        validateSpec({ file })
            .then(response => {
                getProjects().then(resp => {
                    dispatch({
                        type: 'validate-sucsess',
                        payload: { projects: resp.data.projects, file },
                    });
                });
            })
            .catch(function(err) {
                if (Array.isArray(err.response.data)) {
                    dispatch({
                        type: 'validate-error',
                        payload: Object.values(err.response.data),
                    });
                } else {
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
        createProject(file)
            .then(response => {
                document.location.href = window.location.origin + '/project/update/' + response.data.id;
            })
            .catch(error => {});
    };

    const openNotificationWithIcon = (type, message, description) => {
        notification[type]({
            message,
            description,
            duration: 0,
        });
    };

    const handleCompare = () => {
        if (selectedProjects.length) {
            dispatch({ type: 'projects-changes-request' });

            selectedProjects.forEach((project, i) => {
                compareProject(file, project.id)
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
                    .catch(error => {});
                selectedProjects.length === i + 1 && dispatch({ type: 'fetch-success' });
            });
        } else {
            openNotificationWithIcon(
                'error',
                'Не выбраны проекты',
                'Для загрузки спецификации выберите проекты из списка.',
            );
        }
    };

    const formatErrors = [];
    errors.forEach(type => {
        type.forEach(error => {
            formatErrors.push(error);
        });
    });

    return (
        <Modal
            isOpen={isOpen}
            onClose={handleCloseModal}
            children={
                <React.Fragment>
                    {selectProjectOpen ? (
                        <Projects
                            createFromFile={handleCreateProject}
                            changeCheckbox={handleChangeCheckbox}
                            projects={projects}
                            selectedProjects={selectedProjects}
                            compareProjects={handleCompare}
                            projectsChanges={projectsChanges}
                            isFetch={isFetch}
                        />
                    ) : (
                        <Uplaod
                            formatErrors={formatErrors}
                            validateErrors={validateErrors}
                            uploadSpec={handleUploadSpec}
                            validateFetch={isFetch}
                            exampleSpec={exampleSpec}
                        />
                    )}
                </React.Fragment>
            }
        />
    );
};

export default UploadSpec;
