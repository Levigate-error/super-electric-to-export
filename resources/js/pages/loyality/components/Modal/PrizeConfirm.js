"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const PrizeConfirm = ({ setModalState, prizePoints }) => {
    const handleConfirm = () => {
        setModalState('prize-check');
    };
    return (React.createElement(React.Fragment, null,
        React.createElement("h1", { className: "mb-3 loyalty-modal__title" }, "\u0412\u044B\u0431\u043E\u0440 \u043F\u0440\u0438\u0437\u0430"),
        React.createElement("p", null,
            "\u0412\u044B \u0432\u044B\u0431\u0440\u0430\u043B\u0438 \u043F\u0440\u0438\u0437 \u201C\u0424\u0443\u0442\u0431\u043E\u043B\u043A\u0430 Superelektrik\u201D \u0441 \u0432\u0430\u0448\u0435\u0433\u043E \u0431\u0430\u043B\u0430\u043D\u0441\u0430 \u0431\u0430\u043B\u043B\u043E\u0432 \u0431\u0443\u0434\u0435\u0442 \u0441\u043F\u0438\u0441\u0430\u043D\u043E ",
            prizePoints,
            " \u0431\u0430\u043B\u043B\u043E\u0432"),
        React.createElement("button", { type: "button", className: "loyalty-modal__btn loyalty-modal__btn--red", onClick: handleConfirm }, "\u0421\u043E\u0433\u043B\u0430\u0441\u0435\u043D")));
};
exports.default = PrizeConfirm;
