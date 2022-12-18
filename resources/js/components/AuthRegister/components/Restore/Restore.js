"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const reducer_1 = require("./reducer");
const Input_1 = require("../../../../ui/Input");
const Button_1 = require("../../../../ui/Button");
const api_1 = require("./api");
const helper_1 = require("./helper");
const Restore = ({ csrf }) => {
    const [{ email, emailError, success }, dispatch] = React.useReducer(reducer_1.reducer, reducer_1.initalState);
    const handleChangeInput = React.useCallback(({ target }) => {
        switch (target.name) {
            case 'email':
                dispatch({
                    type: reducer_1.actionTypes.SET_EMAIL,
                    payload: target.value,
                });
                break;
        }
    }, [email]);
    const handleSubmit = () => {
        api_1.reset({ email, csrf })
            .then(response => {
            if (response.errors) {
                dispatch({
                    type: reducer_1.actionTypes.RESET_FAILURE,
                    payload: response.message,
                });
                helper_1.setErrorHelper(dispatch, response.errors);
            }
            else {
                dispatch({
                    type: reducer_1.actionTypes.RESET_SUCCESS,
                });
            }
        })
            .catch(err => { });
    };
    return (React.createElement("div", { className: "auth-register-modal-wrapper" },
        React.createElement("h3", { className: "auth-register-modal-title" }, "\u0412\u043E\u0441\u0441\u0442\u0430\u043D\u043E\u0432\u043B\u0435\u043D\u0438\u0435 \u043F\u0430\u0440\u043E\u043B\u044F"),
        success ? (React.createElement("div", { className: "auth-register-input-row" }, "\u041D\u0430 \u0443\u043A\u0430\u0437\u0430\u043D\u043D\u044B\u0439 \u0430\u0434\u0440\u0435\u0441 \u043E\u0442\u043F\u0440\u0430\u0432\u043B\u0435\u043D\u043E \u043F\u0438\u0441\u044C\u043C\u043E \u0441\u043E \u0441\u0441\u044B\u043B\u043A\u043E\u0439 \u0434\u043B\u044F \u0432\u043E\u0441\u0441\u0442\u0430\u043D\u043E\u0432\u043B\u0435\u043D\u0438\u044F \u043F\u0430\u0440\u043E\u043B\u044F")) : (React.createElement(React.Fragment, null,
            React.createElement("div", { className: "auth-register-input-row auth-register-reset-info" },
                "\u0412\u0432\u0435\u0434\u0438\u0442\u0435 \u0412\u0430\u0448 E-mail \u0438 \u043C\u044B \u043F\u0440\u0438\u0448\u043B\u0435\u043C",
                React.createElement("br", null),
                " \u0441\u0441\u044B\u043B\u043A\u0443 \u0434\u043B\u044F \u0432\u043E\u0441\u0441\u0442\u0430\u043D\u043E\u0432\u043B\u0435\u043D\u0438\u044F \u043F\u0430\u0440\u043E\u043B\u044F"),
            React.createElement("div", { className: "auth-register-input-row" },
                React.createElement(Input_1.default, { value: email, error: emailError, onChange: handleChangeInput, label: "E-mail", placeholder: "Введите E-mail", name: "email" })),
            React.createElement("div", { className: "auth-register-input-row auth-register-confirm" },
                React.createElement(Button_1.default, { onClick: handleSubmit, value: "Сбросить пароль", appearance: "accent" }))))));
};
exports.default = Restore;
