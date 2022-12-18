"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Radio = ({ values, onChange, defaultValue }) => {
    const [selected, setSelected] = React.useState(defaultValue);
    const handleOptionChange = e => {
        const value = parseInt(e.target.value);
        setSelected(value);
        onChange(value);
    };
    return (React.createElement("form", null, values.map(item => (React.createElement("div", { className: "radio" },
        React.createElement("input", { id: `radio-${item.id}`, value: item.value, name: "radio", type: "radio", onChange: handleOptionChange, checked: selected === item.value }),
        React.createElement("label", { htmlFor: `radio-${item.id}`, className: "radio-label" }, item.text))))));
};
exports.default = Radio;
