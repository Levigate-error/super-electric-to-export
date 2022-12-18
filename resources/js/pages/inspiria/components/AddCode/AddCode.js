"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Button_1 = require("../../../../ui/Button");
const Input_1 = require("../../../../ui/Input");
const reducer_1 = require("./reducer");
const antd_1 = require("antd");
const api_1 = require("../../api");
const firstStepStyle = {
    btn: {
        width: 200,
        marginTop: 40,
    },
    text: {
        marginTop: 20,
        marginBottom: 40,
    },
    icon: {
        marginLeft: 10,
    },
};
const secondStepStyle = {
    btn: {
        width: 100,
        marginTop: 40,
    },
    text: {
        marginTop: 40,
    },
    secondText: {
        marginBottom: 20,
    },
};
const AddCode = ({ mail, loyaltyId, close = () => { } }) => {
    const [{ step, code, isLoading, error }, dispatch] = React.useReducer(reducer_1.reducer, reducer_1.initialState);
    const handleToStepTwo = () => {
        dispatch({ type: reducer_1.actionTypes.FETCH });
        api_1.registerProductCode(code, loyaltyId)
            .then(response => {
            if (response.errors) {
                response.errors.code &&
                    dispatch({
                        type: reducer_1.actionTypes.FETCH_FAILURE,
                        payload: response.errors.code[0],
                    });
            }
            else if (response.message) {
                dispatch({
                    type: reducer_1.actionTypes.FETCH_FAILURE,
                    payload: response.message,
                });
            }
            else {
                dispatch({ type: reducer_1.actionTypes.FETCH_SUCCESS });
            }
        })
            .catch(err => { });
    };
    const handleChangeCode = e => dispatch({ type: reducer_1.actionTypes.SET_CODE, payload: e.target.value });
    const handleComplete = () => close();
    return (React.createElement("div", { className: "loyality-modal--wrapper" },
        step === 1 && (React.createElement(React.Fragment, null,
            React.createElement("h3", null, "\u0420\u0435\u0433\u0438\u0441\u0442\u0440\u0438\u0440\u0443\u0439\u0442\u0435 \u043F\u0440\u043E\u043C\u043E\u043A\u043E\u0434\u044B \u0438\u043B\u0438 \u0441\u0435\u0440\u0438\u0439\u043D\u044B\u0435 \u043D\u043E\u043C\u0435\u0440\u0430 Wi-Fi \u0448\u043B\u044E\u0437\u043E\u0432 \u0438 \u043F\u043E\u043B\u0443\u0447\u0430\u0439\u0442\u0435 \u0431\u0430\u043B\u043B\u044B"),
            React.createElement(Input_1.default, { onChange: handleChangeCode, value: code, placeholder: "", label: "" }),
            error && React.createElement("span", { className: "loyality-modal-errors" }, error),
            React.createElement(Button_1.default, { onClick: handleToStepTwo, value: isLoading ? (React.createElement(React.Fragment, null,
                    "\u0417\u0430\u0440\u0435\u0433\u0438\u0441\u0442\u0440\u0438\u0440\u043E\u0432\u0430\u0442\u044C ",
                    React.createElement(antd_1.Icon, { type: "loading", style: firstStepStyle.icon }))) : ('Зарегистрировать'), style: firstStepStyle.btn }))),
        step === 2 && (React.createElement(React.Fragment, null,
            React.createElement("h3", null, "\u0421\u043F\u0430\u0441\u0438\u0431\u043E!"),
            React.createElement("div", { style: secondStepStyle.text },
                React.createElement("div", { style: secondStepStyle.secondText }, "\u0412\u0430\u0448\u0430 \u0437\u0430\u044F\u0432\u043A\u0430 \u043D\u0430\u0445\u043E\u0434\u0438\u0442\u0441\u044F \u043D\u0430 \u043C\u043E\u0434\u0435\u0440\u0430\u0446\u0438\u0438"),
                "\u041F\u043E\u0441\u043B\u0435 \u043F\u0440\u043E\u0445\u043E\u0436\u0434\u0435\u043D\u0438\u044F \u043C\u043E\u0434\u0435\u0440\u0430\u0446\u0438\u0438 \u043D\u0430 ",
                React.createElement("br", null),
                React.createElement("strong", null, mail),
                " ",
                React.createElement("br", null),
                " \u043F\u0440\u0438\u0434\u0435\u0442 \u0443\u0432\u0435\u0434\u043E\u043C\u043B\u0435\u043D\u0438\u0435."),
            React.createElement(Button_1.default, { onClick: handleComplete, value: "Понятно", style: secondStepStyle.btn })))));
};
exports.default = AddCode;
