"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const classnames_1 = require("classnames");
const Breadcrumbs = ({ breadcrumbs = [] }) => {
    return (breadcrumbs.length > 0 && (React.createElement("section", { id: "breadcrumbs" },
        React.createElement("div", { className: "container" },
            React.createElement("div", { className: "row" },
                React.createElement("div", { className: "col-lg-12" },
                    React.createElement("ul", { className: "breadcrumb" },
                        React.createElement("li", null,
                            React.createElement("a", { href: "/" }, "\u0413\u043B\u0430\u0432\u043D\u0430\u044F")),
                        breadcrumbs.map(el => (React.createElement("li", { className: classnames_1.default("breadcrumbs-item", { active: !el.url }), key: el.title }, el.url ? (React.createElement("a", { href: el.url }, el.title)) : (el.title)))))))))));
};
exports.default = Breadcrumbs;
