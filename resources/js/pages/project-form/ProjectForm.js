"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const GeneralInformation_1 = require("./components/GeneralInformation");
const TabLinks_1 = require("../../ui/TabLinks");
const PageLayout_1 = require("../../components/PageLayout");
const links = [
    {
        url: '/project/update',
        title: 'Общая информация',
        selected: true,
    },
    {
        url: '/project/products',
        title: 'Добавленная продукция',
        selected: false,
    },
    {
        url: '/project/specifications',
        title: 'Спецификация',
        selected: false,
    },
];
function ProjectForm({ store }) {
    return (React.createElement("div", { className: "container mt-4 mb-3" },
        React.createElement("div", { className: "row " },
            React.createElement("div", { className: "col-md-12" },
                React.createElement(TabLinks_1.default, { id: store.project.id, links: links }))),
        React.createElement("div", { className: "row " },
            React.createElement("div", { className: "col-md-12" },
                React.createElement(GeneralInformation_1.default, { store: store })))));
}
exports.default = PageLayout_1.default(ProjectForm);
