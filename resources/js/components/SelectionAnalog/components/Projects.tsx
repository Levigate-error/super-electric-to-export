import * as React from 'react';
import Checkbox from '../../../ui/Checkbox';
import Button from '../../../ui/Button';

interface IProjects {
    projects: any[];
    changeCount: (e, value) => void;
    addProducts: () => void;
    chengeChecked: (value: boolean, id: number) => void;
    addProductsIsLoading: boolean;
    checkedCount: number;
}

const Projects = ({
    projects,
    changeCount,
    addProducts,
    chengeChecked,
    addProductsIsLoading,
    checkedCount,
}: IProjects) => {
    const projectsIsChecked = !!projects.filter(item => item.checked).length;

    return (
        <React.Fragment>
            <ul className="selection-analog-projects-list">
                {projects.map(project => (
                    <Project
                        project={project}
                        changeCount={changeCount}
                        key={project.id}
                        chengeChecked={chengeChecked}
                    />
                ))}
            </ul>
            <div className="selection-analog-add-product-wrapper">
                <Button
                    onClick={addProducts}
                    value="Добавить"
                    disabled={addProductsIsLoading || !projectsIsChecked}
                    isLoading={addProductsIsLoading}
                    appearance="accent"
                    className="selection-analog-add-product-btn"
                />
            </div>
        </React.Fragment>
    );
};

interface IProject {
    project: any;
    changeCount: (e, value) => void;
    chengeChecked: (value: boolean, id: number) => void;
}

const Project = ({ project, changeCount, chengeChecked }: IProject) => {
    const amountInput = React.useRef(null);

    const handleChangeCount = e => {
        let value = parseInt(e.target.value);
        if (!!value || value === 0) {
            if (value < 1) {
                value = 1;
            }
            changeCount(e, value);
        }
    };

    const handleBlur = e => {
        let value = parseInt(e.target.value);

        if (!value || value < 1) {
            amountInput.current.value = '1';
            changeCount(e, 1);
        }
    };

    return (
        <li className="selection-analog-projects-list-item">
            <Checkbox
                id={project.id}
                checked={!!project.checked}
                onChange={value => chengeChecked(value, project.id)}
            />
            <div className="selection-analog-projects-list-title">{project.title}</div>
            <input
                className="form-control shadow-none legrand-input selection-analog-projects-list-input"
                ref={amountInput}
                onChange={handleChangeCount}
                onBlur={handleBlur}
                defaultValue={1}
                type="number"
                data-id={project.id}
            />
        </li>
    );
};

export default Projects;
