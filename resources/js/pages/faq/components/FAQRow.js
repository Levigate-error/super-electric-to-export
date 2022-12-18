"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const classnames_1 = require("classnames");
const antd_1 = require("antd");
const FAQRow = ({ row }) => {
    const [isOpen, setIsOpen] = React.useState(false);
    const handleToggleRow = () => setIsOpen(!isOpen);
    return (React.createElement("div", { className: "faq-row-wrapper" },
        React.createElement("div", { className: "faq-row-head", onClick: handleToggleRow },
            React.createElement("div", { className: "faq-row-title" },
                React.createElement("div", { className: "content", dangerouslySetInnerHTML: { __html: row.question } })),
            React.createElement(antd_1.Icon, { type: isOpen ? 'up' : 'down', className: "faq-row-icon" })),
        React.createElement("div", { className: classnames_1.default('faq-row-description', { 'faq-row-description-hidden': !isOpen }) },
            React.createElement("div", { className: "content", dangerouslySetInnerHTML: { __html: row.answer } }))));
};
exports.default = FAQRow;
