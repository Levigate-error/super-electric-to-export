import * as React from 'react';
import { IProjectsList } from './types';
import Button from '../../ui/Button';
import Grid from '../../ui/Grid';
import { getProjects, removeProject } from './api';
import PageLayout from '../../components/PageLayout';
import { Icon, Modal, ConfigProvider, Empty } from 'antd';

const gridStyle = {
    paddingTop: 40,
};

interface IState {
    selectedFilter: number;
    projects: any;
    allSelected: boolean;
    removeModalVisibility: boolean;
    currentId: number;
    isLoading: boolean;
    projectsIsLoading: boolean;
}

const btnStyle = {
    marginLeft: 10,
    marginTop: 10,
};

const removeBtnStyle = {
    float: 'right',
    marginLeft: 10,
};

const customizeRenderEmpty = () => <Empty description={'У вас еще нет ни одного проекта или вы не авторизовались'} />;

export class ProjectsList extends React.Component<IProjectsList, IState> {
    state = {
        selectedFilter: null,
        projects: this.props.store.projects.projects,
        allSelected: true,
        removeModalVisibility: false,
        currentId: null,
        isLoading: false,
        projectsIsLoading: false,
    };

    handleOpenRemoveModal = (e, id) => {
        e.stopPropagation();
        this.setState({ removeModalVisibility: true, currentId: id });
    };

    handleRemoveProjectApply = () => {
        const { currentId } = this.state;
        this.setState({ isLoading: true });
        currentId &&
            removeProject(currentId)
                .then(response => {
                    this.setState({ isLoading: false });

                    this.closeModal();
                    this.setShowAllProjects();
                })
                .catch(err => {
                    this.setState({ isLoading: false });
                });
    };

    closeModal = () => this.setState({ removeModalVisibility: false, currentId: null });

    columns = [
        {
            title: 'Название проекта',
            dataIndex: 'title',
            key: 'id',
            render: (text, record) => (
                <button key={record.id} className="projects-list-title" onClick={() => this.selectProject(record)}>
                    {text}
                </button>
            ),
        },
        {
            title: 'Адрес',
            dataIndex: 'address',
            key: 'address',
        },
        {
            title: 'Сумма по проекту',
            key: 'total_price',
            render: record => (
                <span className="projects-list-summ-wrapper" key={record.id}>
                    {record.total_price} ₽
                </span>
            ),
        },
        {
            title: 'Удалить',
            key: 'delete',
            render: record => (
                <div className="project-list-remove-wrapper" key={record.id}>
                    <Icon
                        className="remove-icon"
                        type="close"
                        onClick={e => this.handleOpenRemoveModal(e, record.id)}
                    />
                </div>
            ),
        },
    ];

    setSelectedFilter = id => {
        getProjects({ project_status_id: id }).then(response => {
            this.setState({
                projects: response.data.projects,
                selectedFilter: id,
                allSelected: false,
            });
        });
    };

    setShowAllProjects = () => {
        this.setState({ projectsIsLoading: true });
        getProjects({})
            .then(response => {
                this.setState({
                    projects: response.data.projects,
                    selectedFilter: null,
                    allSelected: true,
                    projectsIsLoading: false,
                });
            })
            .catch(err => {
                this.setState({ projectsIsLoading: true });
            });
    };

    selectProject = record => {
        const base_url = window.location.origin;
        window.location.href = `${base_url}/project/update/${record.id}`;
    };

    render() {
        const {
            store: { statuses },
        } = this.props;
        const {
            selectedFilter,
            projects,
            allSelected,
            removeModalVisibility,
            isLoading,
            projectsIsLoading,
        } = this.state;

        return (
            <div className="container mt-4 mb-3 project-list-wrapper">
                {removeModalVisibility && (
                    <Modal visible={removeModalVisibility} footer={false} width={320} onCancel={this.closeModal}>
                        <h3>Удалить проект?</h3>
                        <div className="project-list-remove-btns-wrapper ">
                            <Button
                                style={removeBtnStyle}
                                onClick={this.handleRemoveProjectApply}
                                value="Удалить"
                                appearance="second"
                                isLoading={isLoading}
                                disabled={isLoading}
                            />
                            <Button
                                style={removeBtnStyle}
                                onClick={this.closeModal}
                                value="Оставить"
                                appearance="accent"
                                disabled={isLoading}
                            />
                        </div>
                    </Modal>
                )}
                <div className="row ">
                    <Button
                        style={btnStyle}
                        appearance="bordered"
                        isActive={allSelected}
                        value="Все проекты"
                        onClick={this.setShowAllProjects}
                    />
                    {statuses.map(item => (
                        <Button
                            style={btnStyle}
                            appearance="bordered"
                            isActive={item.id === selectedFilter}
                            value={item.title}
                            key={item.id}
                            onClick={() => this.setSelectedFilter(item.id)}
                        />
                    ))}
                </div>

                <div className="row" style={gridStyle}>
                    <ConfigProvider renderEmpty={customizeRenderEmpty}>
                        <Grid
                            data={projects}
                            columns={this.columns}
                            paging={false}
                            rowClick={this.selectProject}
                            isLoading={projectsIsLoading}
                        />
                    </ConfigProvider>
                </div>
            </div>
        );
    }
}

export default PageLayout(ProjectsList);
