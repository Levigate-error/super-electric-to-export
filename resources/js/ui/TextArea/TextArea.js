"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const classnames_1 = require("classnames");
const TextArea = ({ rows = 5, maxLength = 1000, name = 'textarea1', value, disabled = false, label, onChange = () => { }, error, }) => {
    const handleChange = e => {
        if (!disabled) {
            onChange(e);
        }
    };
    return (React.createElement("div", { className: classnames_1.default('legrand-textarea-wrapper', { 'with-label': label }) },
        React.createElement("div", { className: "legrand-textarea-labels" },
            label && React.createElement("span", { className: "label-wrapper" }, label),
            error && React.createElement("span", { className: "legrand-textarea-error" }, error)),
        React.createElement("textarea", { className: classnames_1.default('legrand-textarea', { 'legrand-textarea-disabled': disabled }), name: name, rows: rows, onChange: handleChange, value: value, maxLength: maxLength })));
};
exports.default = TextArea;
