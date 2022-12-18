"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Icons_1 = require("../../../../ui/Icons/Icons");
function Instructions({ instructions }) {
    return (React.createElement("ul", { className: "instructions-list" }, instructions.map((item) => (React.createElement("li", { key: item.description },
        React.createElement("a", { target: "_blank", href: item.file_link, title: item.description },
            Icons_1.pdfIcon,
            React.createElement("span", null, item.description)))))));
}
exports.default = React.memo(Instructions);
