"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const antd_1 = require("antd");
function ArrowNext(props) {
    const { onClick, className } = props;
    return (React.createElement("div", { className: className, onClick: onClick },
        React.createElement(antd_1.Icon, { type: "right" })));
}
exports.ArrowNext = ArrowNext;
function ArrowPrev(props) {
    const { onClick, className } = props;
    return (React.createElement("div", { className: className, onClick: onClick },
        React.createElement(antd_1.Icon, { type: "left" })));
}
exports.ArrowPrev = ArrowPrev;
