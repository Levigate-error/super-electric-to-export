"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const antd_1 = require("antd");
const uploadInputStyle = {
    display: 'none',
};
const Upload = ({ validateFetch, formatErrors, uploadSpec, exampleSpec, validateErrors }) => {
    return (React.createElement(React.Fragment, null,
        React.createElement("h3", null, "\u0417\u0430\u0433\u0440\u0443\u0437\u0438\u0442\u044C \u0441\u043F\u0435\u0446\u0438\u0444\u0438\u043A\u0430\u0446\u0438\u044E"),
        React.createElement("p", null, "\u0421\u043A\u0430\u0447\u0430\u0439\u0442\u0435 \u0438 \u0437\u0430\u043F\u043E\u043B\u043D\u0438\u0442\u0435 \u0448\u0430\u0431\u043B\u043E\u043D \u0438\u043B\u0438 \u0437\u0430\u0433\u0440\u0443\u0437\u0438\u0442\u0435 \u0433\u043E\u0442\u043E\u0432\u0443\u044E \u0441\u043F\u0435\u0446\u0438\u0444\u0438\u043A\u0430\u0446\u0438\u044E."),
        exampleSpec && (React.createElement("a", { href: exampleSpec, className: "download-spec-template" },
            React.createElement(antd_1.Icon, { type: "download", className: "spec-template-i" }),
            " \u0421\u043A\u0430\u0447\u0430\u0442\u044C \u0448\u0430\u0431\u043B\u043E\u043D \u0441\u043F\u0435\u0446\u0438\u0444\u0438\u043A\u0430\u0446\u0438\u0438")),
        !formatErrors.length && (React.createElement("div", { className: "upload-spec-wrap" },
            validateFetch ? (React.createElement(antd_1.Icon, { type: "loading", className: "spec-template-i" })) : (React.createElement("label", { htmlFor: "upload-spec-input", className: "upload-spec-input-wrapper" },
                React.createElement(antd_1.Icon, { type: "paper-clip", className: "spec-template-i" }),
                " \u0417\u0430\u0433\u0440\u0443\u0437\u0438\u0442\u044C \u0441\u043F\u0435\u0446\u0438\u0444\u0438\u043A\u0430\u0446\u0438\u044E")),
            React.createElement("input", { id: "upload-spec-input", className: "upload-spec-input", type: "file", style: uploadInputStyle, onChange: uploadSpec }))),
        !!formatErrors.length && (React.createElement("div", { className: "upload-spec-erros-wrapper" },
            React.createElement("span", { className: "upload-spec-erros-title" }, "\u041E\u0448\u0438\u0431\u043A\u0430 \u0432\u0430\u043B\u0438\u0434\u0430\u0446\u0438\u0438"),
            formatErrors.map(err => (React.createElement("span", { className: "validate-spec-error", key: err }, err))))),
        !!validateErrors.length &&
            validateErrors.map(err => (React.createElement("div", { className: "upload-spec-erros-wrapper", key: err.text },
                React.createElement("span", { className: "upload-spec-erros-title" }, "\u041E\u0448\u0438\u0431\u043A\u0430 \u0432\u0430\u043B\u0438\u0434\u0430\u0446\u0438\u0438"),
                React.createElement("span", { className: "upload-spec-format-error-title" }, err.text),
                React.createElement("span", { className: "validate-spec-format-error", key: err }, err.additional))))));
};
exports.default = Upload;
