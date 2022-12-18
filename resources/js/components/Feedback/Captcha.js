"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Recaptcha = require("react-recaptcha");
const Captcha = ({ sitekey = '', onVerify }) => {
    return React.createElement(Recaptcha, { sitekey: sitekey, render: "explicit", verifyCallback: onVerify });
};
exports.default = Captcha;
