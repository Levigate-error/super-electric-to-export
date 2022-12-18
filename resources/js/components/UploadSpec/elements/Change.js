"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Button_1 = require("../../../ui/Button");
const api_1 = require("../api");
const Change = ({ change, projectId }) => {
    const [isApply, setApply] = React.useState(false);
    const handleApply = () => {
        api_1.applyChanges(change.id, projectId)
            .then(response => {
            setApply(true);
        })
            .catch(err => { });
    };
    return (React.createElement("li", { className: "project-changes-item" },
        React.createElement("span", { className: "project-change-type" },
            "\u0418\u0437\u043C\u0435\u043D\u0435\u043D\u0438\u0435: ",
            change.typeOnHuman),
        React.createElement("span", { className: "project-change-vendor" },
            "\u0410\u0440\u0442\u0438\u043A\u0443\u043B: ",
            change.vendor_code),
        React.createElement("span", { className: "project-change-name" },
            "\u041D\u0430\u0437\u0432\u0430\u043D\u0438\u0435: ",
            change.name),
        change.old_value && (React.createElement("span", { className: "project-change-old-value" },
            "\u0421\u0442\u0430\u0440\u043E\u0435 \u0437\u043D\u0430\u0447\u0435\u043D\u0438\u0435:",
            change.old_value)),
        change.new_value && (React.createElement("span", { className: "project-change-new-value" },
            "\u041D\u043E\u0432\u043E\u0435 \u0437\u043D\u0430\u0447\u0435\u043D\u0438\u0435:",
            change.new_value)),
        React.createElement(Button_1.default, { value: isApply ? "сохранено" : "Применить", onClick: handleApply, appearance: isApply ? "second" : "accent", small: true, className: "project-changes-apply-btn", disabled: isApply })));
};
exports.default = Change;
