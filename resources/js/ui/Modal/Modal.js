"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const classnames_1 = require("classnames");
function Modal({ isOpen, onClose, children, hiddenHeader }) {
    const handleClick = e => {
        e.stopPropagation();
    };
    return (React.createElement("div", { className: classnames_1.default("modal", { "fade show": isOpen }), tabIndex: -1, role: "dialog", onClick: onClose },
        React.createElement("div", { className: "modal-dialog modal-dialog-centered", role: "document" },
            React.createElement("div", { className: classnames_1.default("modal-content", {
                    "hidden-header": hiddenHeader
                }), onClick: handleClick },
                !hiddenHeader && (React.createElement("button", { className: "modal-close-btn", onClick: onClose },
                    React.createElement("svg", { width: "19", height: "20", viewBox: "0 0 19 20", fill: "none", xmlns: "http://www.w3.org/2000/svg" },
                        React.createElement("path", { fillRule: "evenodd", clipRule: "evenodd", d: "M9.36143 10.9022L17.9988 19.5456L18.7057 18.8382L10.0683 10.1948L18.7057 1.55144L17.9988 0.844088L9.36143 9.48747L1.03415 1.15442L0.327284 1.86177L8.65457 10.1948L0.327284 18.5279L1.03415 19.2352L9.36143 10.9022Z", fill: "black" })))),
                children))));
}
exports.default = Modal;
