"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Change_1 = require("./Change");
const Changes = ({ projectsChanges }) => {
    return (React.createElement(React.Fragment, null,
        React.createElement("h3", null, "\u0418\u0437\u043C\u0435\u043D\u0435\u043D\u0438\u044F \u0432 \u043F\u0440\u043E\u0435\u043A\u0442\u0430\u0445"),
        React.createElement("div", { className: "project-changes-scroll-wrapper" }, projectsChanges.map(item => (React.createElement("div", { className: "project-changes-section" },
            React.createElement("span", { className: "project-changes-section-title" },
                item.project.title,
                React.createElement("br", null),
                !item.changes.length && (React.createElement("span", { className: "project-changes-no-change" }, "\u041D\u0435\u0442 \u0438\u0437\u043C\u0435\u043D\u0435\u043D\u0438\u0439"))),
            React.createElement("ul", { className: "project-changes-list" }, item.changes.map(change => (React.createElement(Change_1.default, { change: change, projectId: item.project.id }))))))))));
};
exports.default = Changes;
