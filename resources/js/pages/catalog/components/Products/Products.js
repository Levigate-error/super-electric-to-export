"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const classnames_1 = require("classnames");
const Product_1 = require("../Product");
function Products({ showAsRows, products }) {
    return (React.createElement("div", { className: classnames_1.default(showAsRows ? 'products-container-rows' : 'products-container-gird') }, products.map((product) => {
        return React.createElement(Product_1.default, { showAsRows: showAsRows, product: product, key: product.id });
    })));
}
exports.default = React.memo(Products);
