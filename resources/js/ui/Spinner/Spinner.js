"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const classnames_1 = require("classnames");
function Spinner({ type, style = {} }) {
    return (React.createElement("div", { className: classnames_1.default("lds-spinner", type || "default"), style: style },
        React.createElement("div", null),
        React.createElement("div", null),
        React.createElement("div", null),
        React.createElement("div", null),
        React.createElement("div", null),
        React.createElement("div", null),
        React.createElement("div", null),
        React.createElement("div", null),
        React.createElement("div", null),
        React.createElement("div", null),
        React.createElement("div", null),
        React.createElement("div", null)));
}
exports.default = Spinner;
