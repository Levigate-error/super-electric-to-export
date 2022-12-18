"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Checkbox_1 = require("../../../ui/Checkbox");
const Button_1 = require("../../../ui/Button");
const antd_1 = require("antd");
const Projects = ({ projects, selectedProjects, changeCheckbox, changeCount, addToProjects, createProject, productAdded, addProductFailure, addRequest, user }) => {
    const projectsExist = projects.length > 0;
    return (React.createElement("div", { className: "select-analog-projects-wrapper" }, projectsExist && user ? (React.createElement(React.Fragment, null,
        React.createElement("h5", null, "\u0412\u044B\u0431\u0435\u0440\u0438\u0442\u0435 \u043F\u0440\u043E\u0435\u043A\u0442, \u0432 \u043A\u043E\u0442\u043E\u0440\u043E\u043C \u0442\u0440\u0435\u0431\u0443\u0435\u0442\u0441\u044F \u0437\u0430\u043C\u0435\u043D\u0438\u0442\u044C \u0430\u043D\u0430\u043B\u043E\u0433"),
        React.createElement("ul", { className: "select-analog-ul" }, projects.map(el => {
            const selected = !!selectedProjects.find(project => el.id === project.id);
            return (React.createElement("li", { key: el.id, className: "select-analog-li" },
                React.createElement(Checkbox_1.default, { checked: selected, onChange: value => changeCheckbox(el, value) }),
                React.createElement("span", { className: "project-name" }, el.title),
                React.createElement("div", { className: "project-input-wrapper" },
                    React.createElement("input", { className: "form-control shadow-none legrand-input", type: "number", value: el.count, onChange: changeCount, disabled: !selected, "data-id": el.id }))));
        })),
        addProductFailure && (React.createElement("span", { className: "add-product-request-err" }, addProductFailure)),
        productAdded && (React.createElement("span", { className: "add-product-request-success" }, "\u041F\u0440\u043E\u0434\u0443\u043A\u0442 \u0443\u0441\u043F\u0435\u0448\u043D\u043E \u0434\u043E\u0431\u0430\u0432\u043B\u0435\u043D")),
        React.createElement("div", { className: "select-analog-actions" },
            React.createElement(Button_1.default, { onClick: addToProjects, appearance: "accent", disabled: selectedProjects.length <= 0, value: addRequest ? (React.createElement(antd_1.Icon, { type: "loading" })) : ("Добавить") })))) : (React.createElement(React.Fragment, null,
        React.createElement("span", null, user
            ? "У вас нет проектов в работе"
            : "У вас нет проектов в работе, создайте проект или авторизуйтесь"),
        React.createElement("div", { className: "select-analog-actions" },
            React.createElement(Button_1.default, { onClick: createProject, appearance: "accent", value: addRequest ? (React.createElement(antd_1.Icon, { type: "loading" })) : ("Создать проект") }))))));
};
exports.default = Projects;
