"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Checkbox_1 = require("../../../ui/Checkbox");
const Button_1 = require("../../../ui/Button");
const createProjBtnStyle = {
    marginRight: 10,
};
const SelectProjects = ({ projects, selectedProjects, changeCheckbox, createFromFile, compareProjects, isLoading, }) => {
    return (React.createElement(React.Fragment, null,
        React.createElement("h3", null, "\u0412\u044B\u0431\u0438\u0440\u0438\u0442\u0435 \u043F\u0440\u043E\u0435\u043A\u0442\u044B"),
        React.createElement("p", null, "\u0412\u044B\u0431\u0438\u0440\u0438\u0442\u0435 \u043F\u0440\u043E\u0435\u043A\u0442\u044B \u0438\u043B\u0438 \u0441\u043E\u0437\u0434\u0430\u0439\u0442\u0435 \u043D\u043E\u0432\u044B\u0439 \u043F\u0440\u043E\u0435\u043A\u0442 \u0438\u0437 \u0437\u0430\u0433\u0440\u0443\u0436\u0435\u043D\u043D\u043E\u0439 \u0441\u043F\u0435\u0446\u0438\u0444\u0438\u043A\u0430\u0446\u0438\u0438."),
        React.createElement("ul", { className: "upload-spec-select-ul" }, projects.length > 0 ? (projects.map(el => (React.createElement("li", { key: el.id, className: "upload-spec-select-li" },
            React.createElement(Checkbox_1.default, { checked: !!selectedProjects.find(project => el.id === project.id), onChange: value => changeCheckbox(el, value), label: el.title }))))) : (React.createElement("li", null, "\u0423 \u0432\u0430\u0441 \u0435\u0449\u0435 \u043D\u0435\u0442 \u043D\u0438 \u043E\u0434\u043D\u043E\u0433\u043E \u043F\u0440\u043E\u0435\u043A\u0442\u0430"))),
        React.createElement("div", { className: "upload-spec-actions" },
            React.createElement(Button_1.default, { onClick: createFromFile, appearance: "bordered", value: "Создать проект", style: createProjBtnStyle, isLoading: isLoading }),
            React.createElement(Button_1.default, { onClick: compareProjects, disabled: isLoading || !selectedProjects.length, appearance: "accent", value: "Обновить проекты" }))));
};
exports.default = SelectProjects;
