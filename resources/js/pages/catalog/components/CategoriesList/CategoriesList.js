"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Category_1 = require("./Category");
const CategoriesList = ({ categories, filters }) => {
    return (React.createElement(React.Fragment, null, categories.map(category => (React.createElement(Category_1.default, { category: category, filters: filters, key: category.id })))));
};
exports.default = CategoriesList;
