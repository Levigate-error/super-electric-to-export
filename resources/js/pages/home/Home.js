"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const News_1 = require("./components/News");
const Projects_1 = require("./components/Projects");
const PageLayout_1 = require("../../components/PageLayout");
const api_1 = require("./api");
const SelectionAnalog_1 = require("../../components/SelectionAnalog");
const Banner_1 = require("./components/Banner");
class Home extends React.Component {
    constructor() {
        super(...arguments);
        this.state = {
            analogVisibility: false,
            createRequest: false,
        };
        this.handleCreateProject = () => {
            this.setState({ createRequest: true });
            const base_url = window.location.origin;
            api_1.createProject()
                .then(response => {
                document.location.href = base_url + '/project/update/' + response.data.id;
            })
                .catch(err => {
                this.setState({ createRequest: false });
            });
        };
        this.handleOpenAnalogSelect = () => this.setState({ analogVisibility: true });
        this.handleCloseAnalogSelect = () => this.setState({ analogVisibility: false });
    }
    render() {
        const { store: { projects: { projects }, userResource, }, } = this.props;
        const { analogVisibility, createRequest } = this.state;
        return (React.createElement("div", { className: "container mt-3 home-page-wrapper", key: "container" },
            analogVisibility && (React.createElement(SelectionAnalog_1.default, { onClose: this.handleCloseAnalogSelect, isOpen: analogVisibility, user: userResource })),
            React.createElement("div", { className: "row " },
                React.createElement("div", { className: "col-12" },
                    React.createElement(Banner_1.default, null))),
            React.createElement("div", { className: "row mt-3" },
                React.createElement("div", { className: "col-md-8" },
                    React.createElement(News_1.default, null)),
                React.createElement("div", { className: "col-md-4" },
                    React.createElement("a", { href: "https://configurator.legrand.ru/configurator/", className: "card home-page-card mb-3" },
                        React.createElement("div", { className: "home-page-card-background configurator" }))),
                React.createElement("div", { className: "col-md-8" },
                    React.createElement(Projects_1.default, { createProjetc: this.handleCreateProject, projects: projects, createRequest: createRequest })),
                React.createElement("div", { className: "col-md-4" },
                    React.createElement("div", { className: "card home-page-card mb-3", onClick: this.handleOpenAnalogSelect },
                        React.createElement("div", { className: "home-page-card-background analog-selection" }),
                        React.createElement("span", { className: "title" }, "\u041F\u043E\u0434\u0431\u043E\u0440 \u043C\u043E\u0434\u0443\u043B\u044C\u043D\u043E\u0433\u043E \u043E\u0431\u043E\u0440\u0443\u0434\u043E\u0432\u0430\u043D\u0438\u044F Legrand \u043F\u043E \u0430\u043D\u0430\u043B\u043E\u0433\u0430\u043C")))),
            React.createElement("div", { className: "row " },
                React.createElement("div", { className: "col-md-4" },
                    React.createElement("a", { href: `catalog?category_id=2`, className: "card home-page-card mb-3" },
                        React.createElement("div", { className: "home-page-card-background modular-equipment" }),
                        React.createElement("span", { className: "title" }, "\u041C\u043E\u0434\u0443\u043B\u044C\u043D\u043E\u0435 \u043E\u0431\u043E\u0440\u0443\u0434\u043E\u0432\u0430\u043D\u0438\u0435"))),
                React.createElement("div", { className: "col-md-4" },
                    React.createElement("a", { href: `catalog?category_id=1`, className: "card home-page-card mb-3" },
                        React.createElement("div", { className: "home-page-card-background  wiring-equipment" }),
                        React.createElement("span", { className: "title" }, "\u042D\u043B\u0435\u043A\u0442\u0440\u043E\u0443\u0441\u0442\u0430\u043D\u043E\u0432\u043E\u0447\u043D\u043E\u0435 \u043E\u0431\u043E\u0440\u0443\u0434\u043E\u0432\u0430\u043D\u0438\u0435"))),
                React.createElement("div", { className: "col-md-4" },
                    React.createElement("a", { href: "https://legrand.ru/services/learning", target: "_blank", className: "card home-page-card mb-3" },
                        React.createElement("div", { className: "home-page-card-background training" }),
                        React.createElement("span", { className: "title" }, "\u041E\u0431\u0443\u0447\u0435\u043D\u0438\u0435"))))));
    }
}
exports.default = PageLayout_1.default(Home);
