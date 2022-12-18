import * as React from "react";
import Change from "./Change";

interface IChanges {
    projectsChanges: any;
}

const Changes = ({ projectsChanges }: IChanges) => {
    return (
        <React.Fragment>
            <h3>Изменения в проектах</h3>

            <div className="project-changes-scroll-wrapper">
                {projectsChanges.map(item => (
                    <div className="project-changes-section">
                        <span className="project-changes-section-title">
                            {item.project.title}
                            <br />
                            {!item.changes.length && (
                                <span className="project-changes-no-change">
                                    Нет изменений
                                </span>
                            )}
                        </span>
                        <ul className="project-changes-list">
                            {item.changes.map(change => (
                                <Change
                                    change={change}
                                    projectId={item.project.id}
                                />
                            ))}
                        </ul>
                    </div>
                ))}
            </div>
        </React.Fragment>
    );
};

export default Changes;
