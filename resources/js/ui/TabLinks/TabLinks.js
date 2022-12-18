"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const classnames_1 = require("classnames");
const TabLinks = ({ links, id }) => {
    return (React.createElement("div", { className: "tab-links" },
        React.createElement("ul", null, links.map((link) => (React.createElement("li", { key: link.title, className: classnames_1.default({
                "tab-link-selected": link.selected
            }) },
            React.createElement("a", { href: `${link.url}/${id}` }, link.title)))))));
};
exports.default = TabLinks;
