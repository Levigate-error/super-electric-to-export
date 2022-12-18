"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Button_1 = require("../../../../ui/Button");
const Input_1 = require("../../../../ui/Input");
const api_1 = require("../../api");
const antd_1 = require("antd");
const reducer_1 = require("./reducer");
const PageLayout_1 = require("../../../../components/PageLayout/PageLayout");
const firstStepStyle = {
    btn: {
        width: 170,
    },
    link: {
        marginTop: 8,
    },
};
const secondStepStyle = {
    btn: {
        width: 210,
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
const thirdStepStyle = {
    btn: {
        width: 100,
        marginTop: 40,
    },
    text: {
        marginTop: 40,
    },
};
const Participate = ({ close }) => {
    const [{ step, vin, isLoading, error, codeError, loyaltyError }, dispatch] = React.useReducer(reducer_1.reducer, reducer_1.initialState);
    const usrCtx = React.useContext(PageLayout_1.UserContext);
    const handleToStepTwo = () => {
        dispatch({ type: reducer_1.actionTypes.SET_STEP, payload: 2 });
    };
    const handleToStepThree = () => {
        dispatch({ type: reducer_1.actionTypes.REGISTER });
        api_1.registerVIN(vin)
            .then(response => {
            if (response.errors) {
                response.errors.code &&
                    dispatch({
                        type: reducer_1.actionTypes.CODE_ERROR,
                        payload: response.errors.code[0],
                    });
                response.errors.loyalty_id &&
                    dispatch({
                        type: reducer_1.actionTypes.LOYALTY_ID_ERROR,
                        payload: response.errors.loyalty_id[0],
                    });
            }
            else if (response.message) {
                dispatch({
                    type: reducer_1.actionTypes.FIELD_ERROR,
                    payload: response.message,
                });
            }
            else {
                dispatch({ type: reducer_1.actionTypes.SET_STEP, payload: 3 });
            }
        })
            .catch(err => { });
    };
    const handleChangeVIN = e => {
        dispatch({ type: reducer_1.actionTypes.SET_VIN, payload: e.target.value });
    };
    const handleComplete = () => {
        close();
        location.reload();
    };
    const hasPhoto = !!usrCtx.userResource.photo;
    return (React.createElement("div", { className: "loyality-modal-wrapper" },
        step === 1 && (React.createElement(React.Fragment, null,
            React.createElement("h3", null, "\u0423 \u0412\u0430\u0441 \u0435\u0441\u0442\u044C \u0438\u0434\u0435\u043D\u0442\u0438\u0444\u0438\u043A\u0430\u0446\u0438\u043E\u043D\u043D\u044B\u0439 \u043D\u043E\u043C\u0435\u0440 \u0441\u0435\u0440\u0442\u0438\u0444\u0438\u043A\u0430\u0442\u0430?"),
            React.createElement("div", { className: "loyality-modal-controls" },
                React.createElement(Button_1.default, { onClick: handleToStepTwo, value: "Да", style: firstStepStyle.btn }),
                React.createElement("a", { href: "https://legrand.ru/services/learning", target: "_blank", style: firstStepStyle.link }, "\u0417\u0430\u043F\u0438\u0441\u0430\u0442\u044C\u0441\u044F \u043D\u0430 \u043E\u0431\u0443\u0447\u0435\u043D\u0438\u0435")))),
        step === 2 && hasPhoto && (React.createElement(React.Fragment, null,
            React.createElement("h3", null, "\u0412\u0432\u0435\u0434\u0438\u0442\u0435 \u0438\u0434\u0435\u043D\u0442\u0438\u0444\u0438\u043A\u0430\u0446\u0438\u043E\u043D\u043D\u044B\u0439 \u043D\u043E\u043C\u0435\u0440 \u0441\u0435\u0440\u0442\u0438\u0444\u0438\u043A\u0430\u0442\u0430"),
            React.createElement("div", { style: secondStepStyle.text }, "\u0418\u0434\u0435\u043D\u0442\u0438\u0444\u0438\u043A\u0430\u0446\u0438\u043E\u043D\u043D\u044B\u0439 \u043D\u043E\u043C\u0435\u0440 \u0441\u0435\u0440\u0442\u0438\u0444\u0438\u043A\u0430\u0442\u0430 \u0443\u043A\u0430\u0437\u0430\u043D \u043D\u0430 \u0441\u0435\u0440\u0442\u0438\u0444\u0438\u043A\u0430\u0442\u0435"),
            React.createElement(Input_1.default, { onChange: handleChangeVIN, value: vin, placeholder: "Введите номер сертификата", label: "Идентификационный номер сертификата", error: codeError }),
            error && React.createElement("span", { className: "loyality-modal-errors" }, error),
            loyaltyError && React.createElement("span", { className: "loyality-modal-errors" }, loyaltyError),
            React.createElement(Button_1.default, { onClick: handleToStepThree, value: isLoading ? (React.createElement(React.Fragment, null,
                    "\u0417\u0430\u0440\u0435\u0433\u0438\u0441\u0442\u0440\u0438\u0440\u043E\u0432\u0430\u0442\u044C\u0441\u044F ",
                    React.createElement(antd_1.Icon, { type: "loading", style: secondStepStyle.icon }))) : ('Зарегистрироваться'), style: secondStepStyle.btn }))),
        step === 2 && !hasPhoto && (React.createElement(React.Fragment, null,
            React.createElement("h3", null, "\u0420\u0435\u0433\u0438\u0441\u0442\u0440\u0430\u0446\u0438\u044F \u0432 \u043F\u0440\u043E\u0433\u0440\u0430\u043C\u043C\u0435 \u043B\u043E\u044F\u043B\u044C\u043D\u043E\u0441\u0442\u0438"),
            React.createElement("p", null,
                "\u0414\u043B\u044F \u0443\u0447\u0430\u0441\u0442\u0438\u044F \u0432 \u043F\u0440\u043E\u0433\u0440\u0430\u043C\u043C\u0435 \u043B\u043E\u044F\u043B\u044C\u043D\u043E\u0441\u0442\u0438 \u043D\u0435\u043E\u0431\u0445\u043E\u0434\u0438\u043C\u043E \u0437\u0430\u043F\u043E\u043B\u043D\u0438\u0442\u044C \u0444\u043E\u0442\u043E\u0433\u0440\u0430\u0444\u0438\u044E \u0432",
                ' ',
                React.createElement("a", { href: "user/profile", className: "legrand-text-btn" }, "\u043F\u0440\u043E\u0444\u0438\u043B\u0435")))),
        step === 3 && (React.createElement(React.Fragment, null,
            React.createElement("h3", null, "\u0421\u043F\u0430\u0441\u0438\u0431\u043E \u0437\u0430 \u0440\u0435\u0433\u0438\u0441\u0442\u0440\u0430\u0446\u0438\u044E"),
            React.createElement("div", { style: thirdStepStyle.text },
                "\u041C\u044B \u0440\u0430\u0434\u044B \u0412\u0430\u0448\u0435\u043C\u0443 \u0443\u0447\u0430\u0441\u0442\u0438\u044E",
                React.createElement("br", null),
                " \u0432 \u043D\u0430\u0448\u0435\u0439 \u043F\u0440\u043E\u0433\u0440\u0430\u043C\u043C\u0435 \u043B\u043E\u044F\u043B\u044C\u043D\u043E\u0441\u0442\u0438"),
            React.createElement(Button_1.default, { onClick: handleComplete, value: "Начать", style: thirdStepStyle.btn })))));
};
exports.default = Participate;
