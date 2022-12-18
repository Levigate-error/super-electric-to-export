import * as React from 'react';
import { addCircle } from '../../../../ui/Icons/Icons';
import { IProjects } from './types';
import * as moment from 'moment';
import { Icon } from 'antd';

const iconStyle = {
    verticalAlign: 'baseline',
    fontSize: 64,
};

export default function Projects({ createProjetc, createRequest, projects = [] }: IProjects) {
    const formatDate = date => moment(date).format('MMM DD YYYY H:mm ');

    return (
        <div className="card home-page-card mb-3">
            <div className="projects-wrapper">
                <div className="projects-bg" />

                {projects.length > 0 ? (
                    <React.Fragment>
                        <span className="title">
                            <a href="/project/list" className="main-page-projects-title-link">
                                Ваши последние проекты:
                            </a>
                        </span>
                        <ul className="main-page-projects-list">
                            {projects.map(project => (
                                <li className="main-page-projects-item" key={project.id}>
                                    <a href={`/project/update/${project.id}`}>
                                        <span className="main-page-projects-date">
                                            {formatDate(project.updated_at)} |
                                        </span>
                                        {project.title}
                                    </a>
                                </li>
                            ))}
                        </ul>
                    </React.Fragment>
                ) : (
                    <React.Fragment>
                        <span className="title">Создайте свой первый проект.</span>
                        <button className="main-page-create-proj-btn" onClick={createProjetc} disabled={createRequest}>
                            {createRequest ? <Icon type="loading" style={iconStyle} /> : addCircle}
                        </button>
                    </React.Fragment>
                )}
            </div>
        </div>
    );
}
