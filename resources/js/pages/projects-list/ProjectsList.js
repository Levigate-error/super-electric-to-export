"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Button_1 = require("../../ui/Button");
const Grid_1 = require("../../ui/Grid");
const api_1 = require("./api");
const PageLayout_1 = require("../../components/PageLayout");
const antd_1 = require("antd");
const gridStyle = {
    paddingTop: 40,
};
const btnStyle = {
    marginLeft: 10,
    marginTop: 10,
};
const removeBtnStyle = {
    float: 'right',
    marginLeft: 10,
};
const customizeRenderEmpty = () => React.createElement(antd_1.Empty, { description: 'У вас еще нет ни одного проекта или вы не авторизовались' });
class ProjectsList extends React.Component {
    constructor() {
        super(...arguments);
        this.state = {
            selectedFilter: null,
            projects: this.props.store.projects.projects,
            allSelected: true,
            removeModalVisibility: false,
            currentId: null,
            isLoading: false,
            projectsIsLoading: false,
        };
        this.handleOpenRemoveModal = (e, id) => {
            e.stopPropagation();
            this.setState({ removeModalVisibility: true, currentId: id });
        };
        this.handleRemoveProjectApply = () => {
            const { currentId } = this.state;
            this.setState({ isLoading: true });
            currentId &&
                api_1.removeProject(currentId)
                    .then(response => {
                    this.setState({ isLoading: false });
                    this.closeModal();
                    this.setShowAllProjects();
                })
                    .catch(err => {
                    this.setState({ isLoading: false });
                });
        };
        this.closeModal = () => this.setState({ removeModalVisibility: false, currentId: null });
        this.columns = [
            {
                title: 'Название проекта',
                dataIndex: 'title',
                key: 'id',
                render: (text, record) => (React.createElement("button", { key: record.id, className: "projects-list-title", onClick: () => this.selectProject(record) }, text)),
            },
            {
                title: 'Адрес',
                dataIndex: 'address',
                key: 'address',
            },
            {
                title: 'Сумма по проекту',
                key: 'total_price',
                render: record => (React.createElement("span", { className: "projects-list-summ-wrapper", key: record.id },
                    record.total_price,
                    " \u20BD")),
            },
            {
                title: 'Удалить',
                key: 'delete',
                render: record => (React.createElement("div", { className: "project-list-remove-wrapper", key: record.id },
                    React.createElement(antd_1.Icon, { className: "remove-icon", type: "close", onClick: e => this.handleOpenRemoveModal(e, record.id) }))),
            },
        ];
        this.setSelectedFilter = id => {
            api_1.getProjects({ project_status_id: id }).then(response => {
                this.setState({
                    projects: response.data.projects,
                    selectedFilter: id,
                    allSelected: false,
                });
            });
        };
        this.setShowAllProjects = () => {
            this.setState({ projectsIsLoading: true });
            api_1.getProjects({})
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
        this.selectProject = record => {
            const base_url = window.location.origin;
            window.location.href = `${base_url}/project/update/${record.id}`;
        };
    }
    render() {
        const { store: { statuses }, } = this.props;
        const { selectedFilter, projects, allSelected, removeModalVisibility, isLoading, projectsIsLoading, } = this.state;
        return (React.createElement("div", { className: "container mt-4 mb-3 project-list-wrapper" },
            removeModalVisibility && (React.createElement(antd_1.Modal, { visible: removeModalVisibility, footer: false, width: 320, onCancel: this.closeModal },
                React.createElement("h3", null, "\u0423\u0434\u0430\u043B\u0438\u0442\u044C \u043F\u0440\u043E\u0435\u043A\u0442?"),
                React.createElement("div", { className: "project-list-remove-btns-wrapper " },
                    React.createElement(Button_1.default, { style: removeBtnStyle, onClick: this.handleRemoveProjectApply, value: "Удалить", appearance: "second", isLoading: isLoading, disabled: isLoading }),
                    React.createElement(Button_1.default, { style: removeBtnStyle, onClick: this.closeModal, value: "Оставить", appearance: "accent", disabled: isLoading })))),
            React.createElement("div", { className: "row " },
                React.createElement(Button_1.default, { style: btnStyle, appearance: "bordered", isActive: allSelected, value: "Все проекты", onClick: this.setShowAllProjects }),
                statuses.map(item => (React.createElement(Button_1.default, { style: btnStyle, appearance: "bordered", isActive: item.id === selectedFilter, value: item.title, key: item.id, onClick: () => this.setSelectedFilter(item.id) })))),
            React.createElement("div", { className: "row", style: gridStyle },
                React.createElement(antd_1.ConfigProvider, { renderEmpty: customizeRenderEmpty },
                    React.createElement(Grid_1.default, { data: projects, columns: this.columns, paging: false, rowClick: this.selectProject, isLoading: projectsIsLoading })))));
    }
}
exports.ProjectsList = ProjectsList;
exports.default = PageLayout_1.default(ProjectsList);
