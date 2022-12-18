"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Check = ({ setModalIsOpen }) => (React.createElement(React.Fragment, null,
    React.createElement("h1", { className: "mb-3 loyalty-modal__title" }, "\u0412\u0430\u0448\u0438 \u0434\u0430\u043D\u043D\u044B\u0435 \u043D\u0430 \u043F\u0440\u043E\u0432\u0435\u0440\u043A\u0435"),
    React.createElement("p", null, "\u041C\u044B \u043F\u0440\u0438\u0448\u043B\u0435\u043C \u0432\u0430\u043C \u0443\u0432\u0435\u0434\u043E\u043C\u043B\u0435\u043D\u0438\u0435 \u043A\u043E\u0433\u0434\u0430 \u043F\u0440\u043E\u0432\u0435\u0440\u0438\u043C \u043A\u043E\u0440\u0440\u0435\u043A\u0442\u043D\u043E\u0441\u0442\u044C \u0432\u0432\u0435\u0434\u0435\u043D\u043D\u044B\u0445 \u0434\u0430\u043D\u043D\u044B\u0445"),
    React.createElement("button", { type: "button", className: "loyalty-modal__btn loyalty-modal__btn--red", onClick: () => setModalIsOpen(false) }, "\u041F\u043E\u043D\u044F\u0442\u043D\u043E")));
exports.default = Check;
