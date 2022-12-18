"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const classnames_1 = require("classnames");
const antd_1 = require("antd");
function Button({ disabled, value, onClick, appearance, isActive, type, style = {}, className, isLoading = false, small = false, tabindex = 0, }) {
    function checkType() {
        switch (appearance) {
            case 'accent':
                return 'btn-accent';
            case 'second':
                return 'btn-second';
            case 'bordered':
                return 'btn-bordered';
            default:
                return 'btn-accent';
        }
    }
    return (React.createElement("button", { className: classnames_1.default('legrand-btn', checkType(), {
            active: isActive,
        }, className, { 'legrand-btn-small': small }, { 'legrand-btn-disabled': disabled }), onClick: onClick, disabled: disabled || isLoading, style: style, type: type || 'button', tabIndex: tabindex },
        value,
        " ",
        isLoading && React.createElement(antd_1.Icon, { type: "loading", className: "legrand-btn-loading-icon" })));
}
exports.default = Button;
