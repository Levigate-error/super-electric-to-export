"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const reducer_1 = require("./reducer");
const Input_1 = require("../../../../ui/Input");
const Checkbox_1 = require("../../../../ui/Checkbox");
const Button_1 = require("../../../../ui/Button");
const api_1 = require("./api");
const helper_1 = require("./helper");
const antd_1 = require("antd");
const loadingIconStyle = {
    marginLeft: 10,
};
const Auth = ({ restorePassword, csrf }) => {
    const [{ email, emailError, password, passwordError, remember, error, isLoading }, dispatch] = React.useReducer(reducer_1.reducer, reducer_1.initalState);
    const handleChangeInput = React.useCallback(({ target }) => {
        switch (target.name) {
            case 'email':
                dispatch({
                    type: reducer_1.actionTypes.SET_EMAIL,
                    payload: target.value,
                });
                break;
            case 'password':
                dispatch({
                    type: reducer_1.actionTypes.SET_PASSWORD,
                    payload: target.value,
                });
                break;
        }
    }, [email, password]);
    const handleChangeUserRemember = (value) => dispatch({ type: reducer_1.actionTypes.SET_REMEMBER, payload: value });
    const handleClickRestorePassword = () => restorePassword();
    const handleSubmit = (e) => {
        e.preventDefault();
        const params = {
            email,
            password,
            _token: csrf,
        };
        if (remember) {
            params.remember = true;
        }
        dispatch({ type: reducer_1.actionTypes.AUTHORIZATION });
        api_1.authorize(params)
            .then(response => {
            if (response.errors) {
                dispatch({
                    type: reducer_1.actionTypes.AUTH_FAILURE,
                    payload: response.message,
                });
                helper_1.setErrorHelper(dispatch, response.errors);
            }
            else if (response.message && !response.errors) {
                dispatch({
                    type: reducer_1.actionTypes.AUTH_FAILURE,
                    payload: response.message,
                });
            }
            else {
                if (typeof window !== 'undefined')
                    document.location.reload();
            }
        })
            .catch(err => { });
    };
    const sumbmitAvailable = emailError || passwordError || error;
    return (React.createElement("div", null,
        React.createElement("h3", { className: "auth-register-modal-title" }, "\u0412\u043E\u0439\u0442\u0438"),
        React.createElement("div", { className: "auth-register-input-row" },
            React.createElement(Input_1.default, { value: email, onChange: handleChangeInput, error: emailError, label: "E-mail", placeholder: "Введите E-mail", tabindex: 1, name: "email" })),
        React.createElement("div", { className: "auth-register-input-row" },
            React.createElement(Input_1.default, { value: password, onChange: handleChangeInput, label: "Пароль", placeholder: "Введите пароль", error: passwordError, isPassword: true, tabindex: 2, name: "password" })),
        React.createElement("div", { className: "auth-register-controls" },
            React.createElement(Checkbox_1.default, { checked: remember, onChange: handleChangeUserRemember, label: "Запомнить", tabindex: 3 }),
            React.createElement("button", { className: "legrand-text-btn", onClick: handleClickRestorePassword, tabIndex: 5 }, "\u0417\u0430\u0431\u044B\u043B\u0438 \u043F\u0430\u0440\u043E\u043B\u044C?")),
        error && (React.createElement("div", { className: "auth-register-error-text-wrapper", dangerouslySetInnerHTML: { __html: error } })),
        React.createElement("div", { className: "auth-register-input-row auth-register-confirm" },
            React.createElement(Button_1.default, { onClick: handleSubmit, value: isLoading ? (React.createElement(React.Fragment, null,
                    "\u0412\u043E\u0439\u0442\u0438 ",
                    React.createElement(antd_1.Icon, { type: "loading", style: loadingIconStyle }))) : ('Войти'), appearance: "accent", disabled: sumbmitAvailable, type: "submit", tabindex: 4 }))));
};
exports.default = Auth;
