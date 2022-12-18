"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
function Attributes({ atrributes }) {
    return (React.createElement("ul", { className: "attributes-list" }, atrributes.map((item) => (React.createElement("li", { key: item.title },
        item.title,
        " ",
        React.createElement("span", null, item.value))))));
}
exports.default = React.memo(Attributes);
