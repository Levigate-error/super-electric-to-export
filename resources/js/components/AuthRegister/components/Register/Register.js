"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const reducer_1 = require("./reducer");
const Input_1 = require("../../../../ui/Input");
const Checkbox_1 = require("../../../../ui/Checkbox");
const Button_1 = require("../../../../ui/Button");
const antd_1 = require("antd");
const api_1 = require("./api");
const helper_1 = require("./helper");
const CityInput_1 = require("../../../../ui/CityInput");
const PhoneInput_1 = require("../../../../ui/PhoneInput");
const loadingIconStyle = {
    marginLeft: 10,
};
const Register = ({ csrf }) => {
    const [{ fetch, name, nameError, lastname, lastnameError, birthday, birthdayError, city_id, cityError, phone, phoneError, email, emailError, password, passwordError, passwordRepeat, passwordRepeatError, privacy, privacyError, subscription, subscriptionError, success, }, dispatch,] = React.useReducer(reducer_1.reducer, reducer_1.initalState);
    const handleChangeInput = React.useCallback(data => {
        // text field event or phone input
        if (data.target) {
            switch (data.target.name) {
                case 'name':
                    dispatch({
                        type: reducer_1.actionTypes.SET_NAME,
                        payload: data.target.value,
                    });
                    break;
                case 'lastname':
                    dispatch({
                        type: reducer_1.actionTypes.SET_LASTNAME,
                        payload: data.target.value,
                    });
                    break;
                case 'birthday':
                    dispatch({
                        type: reducer_1.actionTypes.SET_BIRTHDAY,
                        payload: data.target.value,
                    });
                    break;
                case 'email':
                    dispatch({
                        type: reducer_1.actionTypes.SET_EMAIL,
                        payload: data.target.value,
                    });
                    break;
                case 'password':
                    dispatch({
                        type: reducer_1.actionTypes.SET_PASSWORD,
                        payload: data.target.value,
                    });
                    break;
                case 'passwordRepeat':
                    dispatch({
                        type: reducer_1.actionTypes.SET_REPEAT_PASSWORD,
                        payload: data.target.value,
                    });
                    break;
            }
        }
        else {
            dispatch({
                type: reducer_1.actionTypes.SET_PHONE,
                payload: data,
            });
        }
    }, [name, lastname, birthday, city_id, phone, email, password, passwordRepeat]);
    const handleApplyPrivacy = (value) => dispatch({ type: reducer_1.actionTypes.SET_PRIVACY, payload: value });
    const handleApplySubscription = (value) => dispatch({ type: reducer_1.actionTypes.SET_SUBSCRIPTION, payload: value });
    const handleSubmit = (e) => {
        e.preventDefault();
        dispatch({ type: reducer_1.actionTypes.REGISTER });
        api_1.register({
            name,
            lastname,
            birthday,
            city_id,
            phone,
            email,
            password,
            passwordRepeat,
            privacy,
            subscription,
            csrf,
        })
            .then(response => {
            if (response.errors) {
                dispatch({
                    type: reducer_1.actionTypes.REGISTER_FAILURE,
                    payload: response.message,
                });
                helper_1.setErrorHelper(dispatch, response.errors);
            }
            else {
                dispatch({
                    type: reducer_1.actionTypes.REGISTER_SUCCESS,
                    payload: response.data,
                });
            }
        })
            .catch(err => { });
    };
    const handleSelectCity = (val) => {
        dispatch({
            type: reducer_1.actionTypes.SET_CITY,
            payload: val.id,
        });
    };
    return (React.createElement("form", null,
        React.createElement("h3", { className: "auth-register-modal-title" }, "\u0420\u0435\u0433\u0438\u0441\u0442\u0440\u0430\u0446\u0438\u044F"),
        success ? (React.createElement("div", { className: "auth-register-input-row" }, success)) : (React.createElement(React.Fragment, null,
            React.createElement("div", { className: "auth-register-input-row" },
                React.createElement(Input_1.default, { value: name, onChange: handleChangeInput, label: "Имя", placeholder: "Введите имя", error: nameError, name: "name" })),
            React.createElement("div", { className: "auth-register-input-row" },
                React.createElement(Input_1.default, { value: lastname, onChange: handleChangeInput, label: "Фамилия", placeholder: "Введите фамилию", error: lastnameError, name: "lastname" })),
            React.createElement("div", { className: "auth-register-input-row" },
                React.createElement(Input_1.default, { value: birthday, type: "date", onChange: handleChangeInput, label: "Дата рождения", placeholder: "Введите дату рождения", error: birthdayError, name: "birthday" })),
            React.createElement("div", { className: "auth-register-input-row" },
                React.createElement(CityInput_1.default, { onSelect: handleSelectCity, error: cityError })),
            React.createElement("div", { className: "auth-register-input-row" },
                React.createElement(PhoneInput_1.default, { phoneError: phoneError, defaultCountry: 'ru', value: phone, onChange: handleChangeInput })),
            React.createElement("div", { className: "auth-register-input-row" },
                React.createElement(Input_1.default, { value: email, onChange: handleChangeInput, label: "E-mail", placeholder: "Введите E-mail", error: emailError, name: "email" })),
            React.createElement("div", { className: "auth-register-input-row" },
                React.createElement(Input_1.default, { value: password, onChange: handleChangeInput, label: "Пароль", placeholder: "Введите пароль", isPassword: true, error: passwordError, name: "password" })),
            React.createElement("div", { className: "auth-register-input-row" },
                React.createElement(Input_1.default, { value: passwordRepeat, onChange: handleChangeInput, label: "Повторите пароль", placeholder: "Введите пароль", isPassword: true, error: passwordRepeatError, name: "passwordRepeat" })),
            React.createElement("div", { className: "auth-register-controls" },
                React.createElement("span", null,
                    React.createElement(Checkbox_1.default, { checked: privacy, onChange: handleApplyPrivacy, label: React.createElement("span", null,
                            "\u041F\u043E\u0434\u0442\u0432\u0435\u0440\u0436\u0434\u0430\u044E \u0441\u043E\u0433\u043B\u0430\u0441\u0438\u0435 \u043D\u0430",
                            React.createElement("a", { className: "legrand-text-btn", href: "/Consent to the processing of personal data.pdf", target: "_blank" },
                                ' ',
                                "\u043E\u0431\u0440\u0430\u0431\u043E\u0442\u043A\u0443 \u043F\u0435\u0440\u0441\u043E\u043D\u0430\u043B\u044C\u043D\u044B\u0445 \u0434\u0430\u043D\u043D\u044B\u0445")) }))),
            privacyError && (React.createElement("div", { className: "auth-register-controls auth-register-info-message " }, privacyError)),
            React.createElement("div", { className: "auth-register-controls" },
                React.createElement(Checkbox_1.default, { checked: subscription, onChange: handleApplySubscription, label: React.createElement("span", null,
                        "\u041F\u043E\u0434\u0442\u0432\u0435\u0440\u0436\u0434\u0430\u044E",
                        React.createElement("a", { className: "legrand-text-btn", href: "/Consent To Receive Email Marketing.pdf", target: "_blank" },
                            ' ',
                            "\u0441\u043E\u0433\u043B\u0430\u0441\u0438\u0435",
                            ' '),
                        "\u043D\u0430 \u043F\u043E\u043B\u0443\u0447\u0435\u043D\u0438\u0435 \u0440\u0435\u043A\u043B\u0430\u043C\u043D\u044B\u0445 \u0440\u0430\u0441\u0441\u044B\u043B\u043E\u043A") })),
            subscriptionError && (React.createElement("div", { className: "auth-register-controls auth-register-info-message " }, subscriptionError)),
            React.createElement("div", { className: "auth-register-input-row auth-register-confirm" },
                React.createElement(Button_1.default, { onClick: handleSubmit, value: fetch ? (React.createElement(React.Fragment, null,
                        "\u0417\u0430\u0440\u0435\u0433\u0438\u0441\u0442\u0440\u0438\u0440\u043E\u0432\u0430\u0442\u044C\u0441\u044F ",
                        React.createElement(antd_1.Icon, { type: "loading", style: loadingIconStyle }))) : ('Зарегистрироваться'), appearance: "accent", type: "submit" }))))));
};
exports.default = Register;
