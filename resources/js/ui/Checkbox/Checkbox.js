"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
function Checkbox({ disabled, checked, onChange, label, name = '', tabindex = 0, id }) {
    const handleChange = e => {
        const value = e.target.checked;
        onChange(value);
    };
    return (React.createElement("label", { className: "ui-checkbox" },
        label,
        React.createElement("input", { type: "checkbox", checked: checked, disabled: disabled, onChange: handleChange, name: name, tabIndex: tabindex, "data-id": id || '' }),
        React.createElement("span", { className: "checkmark" })));
}
exports.default = React.memo(Checkbox);
