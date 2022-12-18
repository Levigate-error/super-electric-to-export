import * as React from 'react';

import Changes from './Changes';
import SelectProjects from './SelectProjects';

interface IProjects {
    projects: any[];
    changeCheckbox: (el: any, value: boolean) => void;
    selectedProjects: any[];
    createFromFile: () => void;
    compareProjects: () => void;
    projectsChanges: any[];
    isFetch: boolean;
}

const Projects = ({
    projects,
    selectedProjects,
    changeCheckbox,
    createFromFile,
    compareProjects,
    projectsChanges,
    isFetch,
}: IProjects) => {
    return (
        <div className="upload-spec-select-project">
            {projectsChanges.length ? (
                <Changes projectsChanges={projectsChanges} />
            ) : (
                <SelectProjects
                    projects={projects}
                    selectedProjects={selectedProjects}
                    changeCheckbox={changeCheckbox}
                    createFromFile={createFromFile}
                    compareProjects={compareProjects}
                    isLoading={isFetch}
                />
            )}
        </div>
    );
};

export default Projects;
