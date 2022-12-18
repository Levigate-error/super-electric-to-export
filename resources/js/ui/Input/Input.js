"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Spinner_1 = require("../../ui/Spinner");
const classnames_1 = require("classnames");
const antd_1 = require("antd");
const withIconBorderStyle = {
    borderRight: 'none',
};
const spinnerStyle = {
    position: 'relative',
    height: '24px',
    width: '24px',
    transform: 'scale(0.5)',
    top: '-9px',
    left: '-9px',
};
function Input({ value, onChange = () => { }, placeholder = '', id, icon, name = '', isLoading = false, type = 'text', required = false, iconAction, disabled, label = false, isPassword = false, error = false, tabindex = 0, className, autoComplete = 'on', }) {
    const [stateValue, setStateValue] = React.useState(value);
    const [textSecurity, setTextSecurity] = React.useState(isPassword);
    React.useEffect(() => {
        setStateValue(value);
    }, [value]);
    const handleChange = e => {
        if (!disabled) {
            setStateValue(e.target.value);
            onChange(e);
        }
    };
    const handleChangeTextSecurity = () => setTextSecurity(!textSecurity);
    const handleIconClick = () => {
        if (isPassword) {
            handleChangeTextSecurity();
        }
        else {
            iconAction && iconAction();
        }
    };
    const checkError = () => {
        if (required) {
            if (typeof error === 'boolean' && stateValue === '')
                return 'Обязательное поле';
            if (typeof error === 'boolean' && stateValue !== '')
                return 'Введены некоректные данные';
        }
        else {
            if (typeof error === 'string')
                return error;
            if (typeof error === 'boolean')
                return 'Введены некоректные данные';
        }
    };
    const showIcon = icon || isPassword;
    return (React.createElement("div", { className: classnames_1.default('legrand-input-wrapper', {
            'legrand-input-disabled': disabled,
        }, { 'with-label': label }, className) },
        React.createElement("div", { className: "legrand-input-labels" },
            label && React.createElement("span", { className: "label-wrapper" }, label),
            error && React.createElement("span", { className: "label-error" }, checkError())),
        React.createElement("div", { className: "legrand-input-controls-wrapper" },
            React.createElement("input", { type: isPassword && textSecurity ? 'password' : type, className: classnames_1.default('form-control shadow-none legrand-input', {
                    'legrand-input-password': textSecurity,
                }), placeholder: placeholder, value: stateValue, onChange: handleChange, style: icon ? withIconBorderStyle : {}, name: name, "data-id": id || '', autoComplete: autoComplete, tabIndex: tabindex, required: true }),
            showIcon && (React.createElement("div", { className: classnames_1.default('input-group-append legrand-input-append', {
                    'legrand-input-append-icon-btn': !!iconAction || isPassword,
                }), onClick: handleIconClick },
                React.createElement("div", { className: "input-group-text" }, isLoading ? (React.createElement(Spinner_1.default, { style: spinnerStyle })) : isPassword ? (textSecurity ? (React.createElement(antd_1.Icon, { type: "eye" })) : (React.createElement(antd_1.Icon, { type: "eye-invisible" }))) : (icon)))))));
}
exports.default = React.memo(Input);
