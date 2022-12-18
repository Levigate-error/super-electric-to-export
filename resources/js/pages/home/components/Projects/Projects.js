"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Icons_1 = require("../../../../ui/Icons/Icons");
const moment = require("moment");
const antd_1 = require("antd");
const iconStyle = {
    verticalAlign: 'baseline',
    fontSize: 64,
};
function Projects({ createProjetc, createRequest, projects = [] }) {
    const formatDate = date => moment(date).format('MMM DD YYYY H:mm ');
    return (React.createElement("div", { className: "card home-page-card mb-3" },
        React.createElement("div", { className: "projects-wrapper" },
            React.createElement("div", { className: "projects-bg" }),
            projects.length > 0 ? (React.createElement(React.Fragment, null,
                React.createElement("span", { className: "title" },
                    React.createElement("a", { href: "/project/list", className: "main-page-projects-title-link" }, "\u0412\u0430\u0448\u0438 \u043F\u043E\u0441\u043B\u0435\u0434\u043D\u0438\u0435 \u043F\u0440\u043E\u0435\u043A\u0442\u044B:")),
                React.createElement("ul", { className: "main-page-projects-list" }, projects.map(project => (React.createElement("li", { className: "main-page-projects-item", key: project.id },
                    React.createElement("a", { href: `/project/update/${project.id}` },
                        React.createElement("span", { className: "main-page-projects-date" },
                            formatDate(project.updated_at),
                            " |"),
                        project.title))))))) : (React.createElement(React.Fragment, null,
                React.createElement("span", { className: "title" }, "\u0421\u043E\u0437\u0434\u0430\u0439\u0442\u0435 \u0441\u0432\u043E\u0439 \u043F\u0435\u0440\u0432\u044B\u0439 \u043F\u0440\u043E\u0435\u043A\u0442."),
                React.createElement("button", { className: "main-page-create-proj-btn", onClick: createProjetc, disabled: createRequest }, createRequest ? React.createElement(antd_1.Icon, { type: "loading", style: iconStyle }) : Icons_1.addCircle))))));
}
exports.default = Projects;
