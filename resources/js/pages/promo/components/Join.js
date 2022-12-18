"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const AuthRegister_1 = require("../../../components/AuthRegister");
var EAuthRegister;
(function (EAuthRegister) {
    EAuthRegister[EAuthRegister["Auth"] = 1] = "Auth";
    EAuthRegister[EAuthRegister["Register"] = 2] = "Register";
})(EAuthRegister || (EAuthRegister = {}));
const Join = props => {
    const [authModalIsOpen, setAuthModalIsOpen] = React.useState(false);
    const [authOrRegister, setAuthOrRegister] = React.useState(EAuthRegister.Auth);
    const handleColseAuthModal = () => setAuthModalIsOpen(false);
    const handleOpenRegisterModal = () => {
        setAuthOrRegister(EAuthRegister.Register);
        setAuthModalIsOpen(true);
    };
    if (!props.user) {
        return React.createElement("div", { className: "promo-join" },
            React.createElement("h2", { className: "promo-join__title" }, "\u0440\u0435\u0433\u0438\u0441\u0442\u0440\u0438\u0440\u0443\u0439\u0441\u044F \u0438 \u0432\u044B\u0431\u0438\u0440\u0430\u0439 \u0442\u043E, \u0447\u0442\u043E \u043D\u0443\u0436\u043D\u043E \u0442\u0435\u0431\u0435!"),
            React.createElement("button", { onClick: handleOpenRegisterModal, type: "button", className: "promo-join__btn promo-info__button" }, "\u0417\u0430\u0440\u0435\u0433\u0438\u0441\u0442\u0440\u0438\u0440\u043E\u0432\u0430\u0442\u044C\u0441\u044F"),
            authModalIsOpen && (React.createElement(AuthRegister_1.default, { isOpen: authModalIsOpen, onClose: handleColseAuthModal, defaultTab: authOrRegister })));
    }
    else {
        return React.createElement("div", null);
    }
};
exports.default = Join;
