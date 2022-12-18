"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Icons_1 = require("../../../../../ui/Icons/Icons");
const Category = ({ category, filters }) => {
    const handleSelect = () => {
        filters.current && filters.current.handleSelectCategoryByDropdown(category);
    };
    return (React.createElement("div", { className: "col-auto categories-list-item-wrapper ", onClick: handleSelect },
        React.createElement("div", { className: "card categories-list-item" },
            category.image !== '' ? (React.createElement("img", { src: category.image, className: "categories-list-item-img" })) : (Icons_1.defaultImgIcon),
            React.createElement("div", { className: "categories-list-item-title" }, category.name))));
};
exports.default = Category;
