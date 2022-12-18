"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Icons_1 = require("../../../../../../ui/Icons/Icons");
const Divisions = ({ divisions, selectAction, categoryId }) => {
    const addDivisionitem = () => {
        const baseUrl = window.location.origin;
        window.location.href = `${baseUrl}/catalog?category_id=${categoryId}`;
    };
    return (React.createElement(React.Fragment, null,
        React.createElement("div", { className: "division-item division-item-add-wrapper" },
            React.createElement("button", { className: "add-division-product-btn", onClick: addDivisionitem }, Icons_1.addCircle)),
        divisions.map(item => !!item.product_amount && (React.createElement("div", { className: "division-item", key: item.name, onClick: () => selectAction(item) },
            React.createElement("div", { className: "division-product-img-wrapper" }, Icons_1.electroWhiteBackground),
            React.createElement("div", { className: "division-name" }, item.name),
            React.createElement("div", { className: "division-amount" }, item.product_amount))))));
};
exports.default = Divisions;
