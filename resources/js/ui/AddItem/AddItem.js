"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const antd_1 = require("antd");
const AddItem = ({ action, icon = null, text }) => {
    return (React.createElement("div", { className: "add-item-btn-wrapper" },
        React.createElement(antd_1.Button, { type: "link", onClick: action },
            icon,
            text)));
};
exports.default = AddItem;
