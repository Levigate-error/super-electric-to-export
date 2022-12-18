"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const classnames_1 = require("classnames");
const AuthRegister_1 = require("../../../components/AuthRegister");
const Method_1 = require("../../loyality/components/Modal/Method");
const Modal_1 = require("../../../ui/Modal");
const Manual_1 = require("../../loyality/components/Modal/Manual");
const PersonalInfo_1 = require("../../loyality/components/Modal/PersonalInfo");
const Check_1 = require("../../loyality/components/Modal/Check");
var EAuthRegister;
(function (EAuthRegister) {
    EAuthRegister[EAuthRegister["Auth"] = 1] = "Auth";
    EAuthRegister[EAuthRegister["Register"] = 2] = "Register";
})(EAuthRegister || (EAuthRegister = {}));
const Navbar = props => {
    const [isOpen, toggleMenu] = React.useState(false);
    const [modalState, setModalState] = React.useState('method');
    const [modalIsOpen, setModalIsOpen] = React.useState(false);
    const [authModalIsOpen, setAuthModalIsOpen] = React.useState(false);
    const [authOrRegister, setAuthOrRegister] = React.useState(EAuthRegister.Auth);
    //const [state, dispatch] = React.useReducer(reducer, initialState);
    // React.useEffect(() => {
    //     dispatch({
    //         type: "set-user-is-auth",
    //         payload: !!(typeof window !== "undefined" && window.__USER__)
    //     });
    // }, []);
    const toggleModal = () => {
        setModalIsOpen(!modalIsOpen);
        setModalState('method');
    };
    const handleOpenRegisterModal = () => {
        setAuthOrRegister(EAuthRegister.Register);
        setAuthModalIsOpen(true);
        console.log(authOrRegister);
    };
    const handleColseAuthModal = () => setAuthModalIsOpen(false);
    const handleRegisterReceiptButton = () => {
        if (!props.user) {
            handleOpenRegisterModal();
        }
        else {
            toggleModal();
        }
    };
    return (React.createElement("div", { className: "promo-nav" },
        React.createElement("div", { className: "promo-nav__logo" },
            React.createElement("img", { src: "./images/promo/logo.svg", alt: "Лого" })),
        React.createElement("nav", null,
            React.createElement("ul", { className: classnames_1.default('promo-nav__list', { active: isOpen }) },
                React.createElement("li", { className: "promo-nav__item" },
                    React.createElement("a", { href: "#rules", className: "promo-nav__link" }, "\u041F\u0440\u0430\u0432\u0438\u043B\u0430 \u0430\u043A\u0446\u0438\u0438")),
                React.createElement("li", { className: "promo-nav__item" },
                    React.createElement("a", { href: "#prize", className: "promo-nav__link" }, "\u041F\u0440\u0438\u0437\u044B")),
                React.createElement("li", { className: "promo-nav__item" },
                    React.createElement("a", { href: "#", className: "promo-nav__link" }, "\u041F\u043E\u0431\u0435\u0434\u0438\u0442\u0435\u043B\u0438")),
                React.createElement("li", { className: "promo-nav__item" },
                    React.createElement("a", { href: "#question", className: "promo-nav__link" }, "\u0412\u043E\u043F\u0440\u043E\u0441\u044B-\u043E\u0442\u0432\u0435\u0442\u044B")),
                React.createElement("li", { className: "promo-nav__item" },
                    React.createElement("button", { onClick: handleRegisterReceiptButton, type: "button", className: "promo-nav__btn--mobile" }, "\u0417\u0430\u0440\u0435\u0433\u0438\u0441\u0442\u0440\u0438\u0440\u043E\u0432\u0430\u0442\u044C \u0447\u0435\u043A")))),
        React.createElement("button", { onClick: handleRegisterReceiptButton, type: "button", className: "promo-nav__btn" }, "\u0417\u0430\u0440\u0435\u0433\u0438\u0441\u0442\u0440\u0438\u0440\u043E\u0432\u0430\u0442\u044C \u0447\u0435\u043A"),
        React.createElement("a", { href: "#", onClick: () => toggleMenu(!isOpen), className: "promo-nav__burger burger" },
            React.createElement("span", null, "\u0412\u044B\u0438\u0433\u0440\u0430\u0439 \u043F\u0440\u0438\u0437\u044B"),
            React.createElement("div", { className: classnames_1.default('burger__icon', { active: isOpen }) })),
        authModalIsOpen && (React.createElement(AuthRegister_1.default, { isOpen: authModalIsOpen, onClose: handleColseAuthModal, defaultTab: authOrRegister })),
        React.createElement(Modal_1.default, { isOpen: modalIsOpen, onClose: toggleModal },
            React.createElement("div", { className: "loyalty__loyalty-modal loyalty-modal pt-4 pb-4" },
                modalState === 'method' && React.createElement(Method_1.default, { setModalState: setModalState }),
                modalState === 'manual' && React.createElement(Manual_1.default, { setModalState: setModalState }),
                modalState === 'personalInfo' && React.createElement(PersonalInfo_1.default, { setModalState: setModalState }),
                modalState === 'check' && React.createElement(Check_1.default, { setModalIsOpen: setModalIsOpen })))));
};
exports.default = Navbar;
