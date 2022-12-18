"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
//import {postData} from "../../../../utils/requests";
const api_1 = require("../../api");
let manualData = {
    fp: "",
    fd: "",
    fn: "",
    amount: 0,
    'receipt-datetime': null,
};
const Manual = ({ setModalState }) => {
    const handleSubmit = () => {
        api_1.manuallyUploadReceipt(manualData).then(response => {
            console.log('RESPONSE', response);
            if (response.errors) {
                console.log("ERR");
            }
            else {
                if (response.status != 200) {
                    console.log("ERR");
                    setModalState('manual');
                }
                else {
                    console.log("succsess");
                    setModalState('check');
                }
            }
        });
    };
    const manualDataChange = (e) => {
        manualData[e.target.dataset.key] = e.target.value;
        //console.log(manualData);
    };
    return (React.createElement(React.Fragment, null,
        React.createElement("h1", { className: "mb-3 loyalty-modal__title" }, "\u0420\u0435\u0433\u0438\u0441\u0442\u0440\u0430\u0446\u0438\u044F \u0447\u0435\u043A\u0430"),
        React.createElement("h2", { className: "loyalty-modal__subtitle mb-3" }, "\u0412\u0432\u043E\u0434 \u0447\u0435\u043A\u0430 \u0432\u0440\u0443\u0447\u043D\u0443\u044E"),
        React.createElement("div", { className: "loyalty-modal__manual pb-5 mb-4" },
            React.createElement("div", { className: "loyalty-modal__loyalty-form loyalty-form" },
                React.createElement("div", { className: "loyalty-form__block" },
                    React.createElement("label", { htmlFor: "date", className: "loyalty-form__label" }, "\u0414\u0430\u0442\u0430 \u0438 \u0432\u0440\u0435\u043C\u044F \u043F\u043E\u043A\u0443\u043F\u043A\u0438"),
                    React.createElement("input", { "data-key": "receipt-datetime", type: "datetime-local", id: "date", className: "loyalty-form__input", placeholder: "Введите дату и время", required: true, onChange: (e) => manualDataChange(e) }),
                    React.createElement("b", { className: "loyalty-form__icon" }, "1")),
                React.createElement("div", { className: "loyalty-form__block" },
                    React.createElement("label", { htmlFor: "fn", className: "loyalty-form__label" }, "\u0424\u041D"),
                    React.createElement("input", { "data-key": "fn", type: "text", id: "fn", className: "loyalty-form__input", placeholder: "Введите ФН", required: true, onChange: (e) => manualDataChange(e) }),
                    React.createElement("b", { className: "loyalty-form__icon" }, "2")),
                React.createElement("div", { className: "loyalty-form__block" },
                    React.createElement("label", { htmlFor: "fp", className: "loyalty-form__label" }, "\u0424\u041F"),
                    React.createElement("input", { type: "text", "data-key": "fp", id: "fp", className: "loyalty-form__input", placeholder: "Введите ФП", required: true, onChange: (e) => manualDataChange(e) }),
                    React.createElement("b", { className: "loyalty-form__icon" }, "3")),
                React.createElement("div", { className: "loyalty-form__block" },
                    React.createElement("label", { htmlFor: "fd", className: "loyalty-form__label" }, "\u0424\u0414"),
                    React.createElement("input", { "data-key": "fd", type: "text", id: "fd", className: "loyalty-form__input", placeholder: "Введите ФД", required: true, onChange: (e) => manualDataChange(e) }),
                    React.createElement("b", { className: "loyalty-form__icon" }, "4")),
                React.createElement("div", { className: "loyalty-form__block" },
                    React.createElement("label", { htmlFor: "sum", className: "loyalty-form__label" }, "\u0421\u0443\u043C\u043C\u0430 \u043F\u043E\u043A\u0443\u043F\u043A\u0438"),
                    React.createElement("input", { "data-key": "amount", type: "text", name: "sum", className: "loyalty-form__input", placeholder: "Введите сумму покупки", required: true, onChange: (e) => manualDataChange(e) }),
                    React.createElement("b", { className: "loyalty-form__icon" }, "5")),
                React.createElement("button", { className: "loyalty-form__btn", onClick: handleSubmit }, "\u0417\u0430\u0440\u0435\u0433\u0438\u0441\u0442\u0440\u0438\u0440\u043E\u0432\u0430\u0442\u044C\u0441\u044F")),
            React.createElement("img", { src: "./images/loyalty/check.png", alt: "Пример чека" }))));
};
exports.default = Manual;
