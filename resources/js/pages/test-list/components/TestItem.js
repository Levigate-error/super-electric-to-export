"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const utils_1 = require("../../../utils/utils");
const TestItem = ({ test }) => {
    return (React.createElement("a", { className: "col-auto mb-3", href: `/test/${test.id}` },
        React.createElement("div", { className: "card test-list-item" },
            React.createElement("div", { className: "test-list-item-img-wrapper" },
                React.createElement("div", { className: "test-list-item-img", style: { backgroundImage: `url(${test.image})` } })),
            React.createElement("div", { className: "test-list-item-title" }, test.title),
            React.createElement("div", { className: "test-list-item-count" },
                test.questions.length,
                " ",
                utils_1.num2str(test.questions.length, ['вопрос', 'вопроса', 'вопросов'])))));
};
exports.default = TestItem;
