"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const classnames_1 = require("classnames");
const rodal_1 = require("rodal");
const Button_1 = require("../Button");
const Input_1 = require("../Input");
const Checkbox_1 = require("../Checkbox");
const api_1 = require("./api");
const initialState = {
    atuthScreenIsVisible: false,
    email: "",
    password: "",
    remember: false,
    modalVisibility: false,
    isAuth: false
};
function reducer(state, { type, payload }) {
    switch (type) {
        case "set-user-is-auth":
            return Object.assign({}, state, { isAuth: payload });
        case "modal-visibility":
            return Object.assign({}, state, { modalVisibility: payload });
        case "set-email":
            return Object.assign({}, state, { email: payload });
        case "set-password":
            return Object.assign({}, state, { password: payload });
        case "set-remember":
            return Object.assign({}, state, { remember: payload });
        case "set-errors":
            return Object.assign({}, state, { errors: payload });
        case "set-auth-visibility":
            return Object.assign({}, state, { atuthScreenIsVisible: payload });
        case "reset":
            return Object.assign({}, payload);
        default:
            throw new Error();
    }
}
function AuthModal({ children }) {
    const [state, dispatch] = React.useReducer(reducer, initialState);
    React.useEffect(() => {
        dispatch({
            type: "set-user-is-auth",
            payload: !!(typeof window !== "undefined" && window.__USER__)
        });
    }, []);
    const getToken = () => {
        if (typeof window !== "undefined") {
            const m = document.getElementsByTagName("meta");
            for (var i in m) {
                if (m[i].name == "csrf-token") {
                    return m[i].content;
                }
            }
        }
        return "";
    };
    const _token = getToken();
    const showAuth = () => {
        dispatch({ type: "set-auth-visibility", payload: true });
    };
    const showModal = e => {
        state.isAuth || dispatch({ type: "modal-visibility", payload: true });
    };
    const hideModal = e => {
        dispatch({ type: "reset", payload: initialState });
    };
    const sendAuthData = () => {
        const { email, password, remember } = state;
        dispatch({ type: "set-errors", payload: false });
        const req = { email, password, remember, _token };
        api_1.userAuth(Object.assign({}, req)).then(response => {
            const { errors } = response;
            errors
                ? dispatch({
                    type: "set-errors",
                    payload: Object.keys(errors).map(key => {
                        return errors[key][0];
                    })
                })
                : window.location.reload();
        });
    };
    const handleRegister = () => {
        const base_url = window.location.origin;
        window.location.href = `${base_url}/register`;
    };
    const setRemember = React.useCallback(value => dispatch({
        type: "set-remember",
        payload: value
    }), [dispatch]);
    const setEmailValue = React.useCallback(({ target: { value } }) => dispatch({
        type: "set-email",
        payload: value
    }), [dispatch]);
    const setPasswordValue = React.useCallback(({ target: { value } }) => dispatch({
        type: "set-password",
        payload: value
    }), [dispatch]);
    return (React.createElement(React.Fragment, null,
        React.createElement("span", { onClick: showModal, className: classnames_1.default({
                "auth-modal-click-wrapper": !state.isAuth
            }) }, children),
        React.createElement(rodal_1.default, { visible: state.modalVisibility, onClose: hideModal, height: 265, width: 320 }, state.atuthScreenIsVisible ? (React.createElement("div", { className: "auth-modal-wrapper" },
            React.createElement("form", null,
                React.createElement("div", { className: "form-group row" },
                    React.createElement("label", null,
                        "E-mail",
                        React.createElement(Input_1.default, { value: state.email, onChange: setEmailValue }))),
                React.createElement("div", { className: "form-group row" },
                    React.createElement("label", null,
                        "\u041F\u0430\u0440\u043E\u043B\u044C",
                        React.createElement(Input_1.default, { value: state.password, onChange: setPasswordValue, type: "password" }))),
                React.createElement("div", { className: "form-group row" },
                    React.createElement(Checkbox_1.default, { label: "Запомнить меня", name: "remember", checked: state.remember, onChange: setRemember })),
                state.errors && (React.createElement("div", { className: "form-group row" }, state.errors.map(error => {
                    return (React.createElement("span", { className: "form-error-msg", key: error }, error));
                }))),
                React.createElement("div", { className: "form-group row login-btn-wrapper" },
                    React.createElement(Button_1.default, { onClick: sendAuthData, value: "Войти" }))))) : (React.createElement("div", { className: "auth-modal-wrapper" },
            React.createElement("span", { className: "auth-modal-header" }, "\u0427\u0442\u043E\u0431\u044B \u0441\u043E\u0445\u0440\u0430\u043D\u0438\u0442\u044C \u0438\u043B\u0438 \u043F\u043E\u043A\u0430\u0437\u0430\u0442\u044C \u0438\u0437\u0431\u0440\u0430\u043D\u043D\u044B\u0435 \u0442\u043E\u0432\u0430\u0440\u044B, \u043F\u043E\u0436\u0430\u043B\u0443\u0439\u0441\u0442\u0430 \u0437\u0430\u0440\u0435\u0433\u0438\u0441\u0442\u0440\u0438\u0440\u0443\u0439\u0442\u0435\u0441\u044C \u0438\u043B\u0438 \u0430\u0432\u0442\u043E\u0440\u0438\u0437\u0443\u0439\u0442\u0435\u0441\u044C."),
            React.createElement("div", { className: "auth-modal-btns" },
                React.createElement(Button_1.default, { value: "Авторизация", onClick: showAuth, appearance: "bordered" }),
                React.createElement(Button_1.default, { value: "Регистрация", onClick: handleRegister, appearance: "accent" })))))));
}
exports.default = AuthModal;
