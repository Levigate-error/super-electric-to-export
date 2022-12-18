import * as React from "react";
import Checkbox from "../../../ui/Checkbox";
import Button from "../../../ui/Button";
import { Icon } from "antd";

// TODO: add types
interface IProjects {
    projects: any[];
    changeCheckbox: any;
    selectedProjects: any[];
    changeCount: (e: any) => void;
    addToProjects: () => void;
    createProject: () => void;
    productAdded: boolean;
    addProductFailure: boolean | string;
    addRequest: boolean;
    user: any;
}

const Projects = ({
    projects,
    selectedProjects,
    changeCheckbox,
    changeCount,
    addToProjects,
    createProject,
    productAdded,
    addProductFailure,
    addRequest,
    user
}: IProjects) => {
    const projectsExist = projects.length > 0;

    return (
        <div className="select-analog-projects-wrapper">
            {projectsExist && user ? (
                <React.Fragment>
                    <h5>
                        Выберите проект, в котором требуется заменить аналог
                    </h5>
                    <ul className="select-analog-ul">
                        {projects.map(el => {
                            const selected = !!selectedProjects.find(
                                project => el.id === project.id
                            );

                            return (
                                <li key={el.id} className="select-analog-li">
                                    <Checkbox
                                        checked={selected}
                                        onChange={value =>
                                            changeCheckbox(el, value)
                                        }
                                    />
                                    <span className="project-name">
                                        {el.title}
                                    </span>
                                    <div className="project-input-wrapper">
                                        <input
                                            className="form-control shadow-none legrand-input"
                                            type="number"
                                            value={el.count}
                                            onChange={changeCount}
                                            disabled={!selected}
                                            data-id={el.id}
                                        />
                                    </div>
                                </li>
                            );
                        })}
                    </ul>

                    {addProductFailure && (
                        <span className="add-product-request-err">
                            {addProductFailure}
                        </span>
                    )}

                    {productAdded && (
                        <span className="add-product-request-success">
                            Продукт успешно добавлен
                        </span>
                    )}

                    <div className="select-analog-actions">
                        <Button
                            onClick={addToProjects}
                            appearance="accent"
                            disabled={selectedProjects.length <= 0}
                            value={
                                addRequest ? (
                                    <Icon type="loading" />
                                ) : (
                                    "Добавить"
                                )
                            }
                        />
                    </div>
                </React.Fragment>
            ) : (
                <React.Fragment>
                    <span>
                        {user
                            ? "У вас нет проектов в работе"
                            : "У вас нет проектов в работе, создайте проект или авторизуйтесь"}
                    </span>
                    <div className="select-analog-actions">
                        <Button
                            onClick={createProject}
                            appearance="accent"
                            value={
                                addRequest ? (
                                    <Icon type="loading" />
                                ) : (
                                    "Создать проект"
                                )
                            }
                        />
                    </div>
                </React.Fragment>
            )}
        </div>
    );
};

export default Projects;
