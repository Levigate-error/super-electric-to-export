"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const classnames_1 = require("classnames");
const react_phone_input_2_1 = require("react-phone-input-2");
const PhoneInputComponent = ({ phoneError = false, value = '', onChange, label = 'Телефон', defaultCountry = 'ru', }) => {
    return (React.createElement("div", { className: classnames_1.default('legrand-phone-input-wrapper', {
            'legrand-phone-input-with-label': label,
        }) },
        React.createElement("div", { className: "legrand-phone-input-labels" },
            label && React.createElement("span", { className: "legrand-phone-input-label" }, label),
            phoneError && React.createElement("span", { className: "legrand-phone-input-error" }, phoneError)),
        React.createElement(react_phone_input_2_1.default, { containerClass: "legrand-phone-input-component", inputClass: "legrand-phone-input-control", value: value, onChange: onChange, placeholder: "Телефон" })));
};
exports.default = PhoneInputComponent;
