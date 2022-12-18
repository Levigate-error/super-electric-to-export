import * as React from 'react';
import Checkbox from '../../../ui/Checkbox';
import Button from '../../../ui/Button';

interface ISelectProjects {
    projects: any[];
    changeCheckbox: (el: any, value: boolean) => void;
    selectedProjects: any[];
    createFromFile: () => void;
    compareProjects: () => void;
    isLoading: boolean;
}

const createProjBtnStyle = {
    marginRight: 10,
};

const SelectProjects = ({
    projects,
    selectedProjects,
    changeCheckbox,
    createFromFile,
    compareProjects,
    isLoading,
}: ISelectProjects) => {
    return (
        <React.Fragment>
            <h3>Выбирите проекты</h3>
            <p>Выбирите проекты или создайте новый проект из загруженной спецификации.</p>
            <ul className="upload-spec-select-ul">
                {projects.length > 0 ? (
                    projects.map(el => (
                        <li key={el.id} className="upload-spec-select-li">
                            <Checkbox
                                checked={!!selectedProjects.find(project => el.id === project.id)}
                                onChange={value => changeCheckbox(el, value)}
                                label={el.title}
                            />
                        </li>
                    ))
                ) : (
                    <li>У вас еще нет ни одного проекта</li>
                )}
            </ul>
            <div className="upload-spec-actions">
                <Button
                    onClick={createFromFile}
                    appearance="bordered"
                    value="Создать проект"
                    style={createProjBtnStyle}
                    isLoading={isLoading}
                />
                <Button
                    onClick={compareProjects}
                    disabled={isLoading || !selectedProjects.length}
                    appearance="accent"
                    value="Обновить проекты"
                />
            </div>
        </React.Fragment>
    );
};

export default SelectProjects;
