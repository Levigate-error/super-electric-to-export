"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Input_1 = require("../../../ui/Input");
const Button_1 = require("../../../ui/Button");
const SelectScreen = ({ article, changeArticle, analogNotFound, findAnalog, analogIsLoading }) => {
    const handleChangeArticle = e => {
        const val = e.target.value;
        changeArticle(val);
    };
    return (React.createElement("div", { className: "selection-analog-wrapper" },
        React.createElement("h2", { className: "selection-analog-title" }, "\u041F\u043E\u0434\u0431\u043E\u0440 \u043C\u043E\u0434\u0443\u043B\u044C\u043D\u043E\u0433\u043E \u043E\u0431\u043E\u0440\u0443\u0434\u043E\u0432\u0430\u043D\u0438\u044F Legrand \u043F\u043E \u0430\u043D\u0430\u043B\u043E\u0433\u0430\u043C"),
        React.createElement("div", { className: "selection-analog-description" }, "\u0412\u0432\u0435\u0434\u0438\u0442\u0435 \u0430\u0440\u0442\u0438\u043A\u0443\u043B \u043C\u043E\u0434\u0443\u043B\u044C\u043D\u043E\u0433\u043E \u043E\u0431\u043E\u0440\u0443\u0434\u043E\u0432\u0430\u043D\u0438\u044F \u0434\u0440\u0443\u0433\u0438\u0445 \u043F\u0440\u043E\u0438\u0437\u0432\u043E\u0434\u0438\u0442\u0435\u043B\u0435\u0439 \u0438 \u043F\u0440\u043E\u0433\u0440\u0430\u043C\u043C\u0430 \u043F\u043E\u0434\u0431\u0435\u0440\u0435\u0442 \u0432\u0430\u043C \u0430\u043D\u0430\u043B\u043E\u0433 Legrand."),
        React.createElement(Input_1.default, { value: article, onChange: handleChangeArticle, label: "Артикул", className: "selection-analog-article-input" }),
        React.createElement(Button_1.default, { onClick: findAnalog, value: "Подобрать", appearance: "accent", isLoading: analogIsLoading, className: "selection-analog-get-analog-btn" }),
        analogNotFound && (React.createElement("div", { className: "selection-analog-find-error" },
            "\u0410\u043D\u0430\u043B\u043E\u0433\u0438 \u043D\u0435 \u043D\u0430\u0439\u0434\u0435\u043D\u044B. \u0412\u0432\u0435\u0434\u0438\u0442\u0435 \u043F\u0440\u0430\u0432\u0438\u043B\u044C\u043D\u044B\u0439 \u0430\u0440\u0442\u0438\u043A\u0443\u043B \u0438\u043B\u0438 \u043F\u043E\u0434\u0431\u0435\u0440\u0438\u0442\u0435 \u0430\u043D\u0430\u043B\u043E\u0433 \u0432 \u043D\u0430\u0448\u0435\u043C",
            ' ',
            React.createElement("a", { href: "/catalog", className: "legrand-text-btn" }, "\u041A\u0430\u0442\u0430\u043B\u043E\u0433\u0435"),
            "."))));
};
exports.default = SelectScreen;
