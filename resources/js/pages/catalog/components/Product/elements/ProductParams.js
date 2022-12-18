"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
function ProductParams({ params }) {
    return (React.createElement("ul", { className: "product-params mt-3" }, params.slice(0, 5).map(item => (React.createElement("li", { className: "product-param-row mt-2", key: item.title },
        React.createElement("span", null,
            item.title,
            ":"),
        React.createElement("span", null, item.value))))));
}
exports.ProductParams = ProductParams;
