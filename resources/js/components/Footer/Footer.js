"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const SelectionAnalog_1 = require("../SelectionAnalog");
const UploadSpec_1 = require("../UploadSpec");
const AuthRegister_1 = require("../AuthRegister");
const Feedback_1 = require("../Feedback");
const whiteLogoStyle = {
    width: '100%',
};
class Footer extends React.Component {
    constructor() {
        super(...arguments);
        this.state = {
            analogSelectIsOpen: false,
            uploadSpecIsOpen: false,
            authModalIsOpen: false,
            feedbackIsOpen: false,
        };
        this.handleToggleAnalogSelect = () => this.setState({ analogSelectIsOpen: !this.state.analogSelectIsOpen });
        this.handleUploadSpecToggle = () => this.setState({ uploadSpecIsOpen: !this.state.uploadSpecIsOpen });
        this.handleToggleAuthModal = () => this.setState({ authModalIsOpen: !this.state.authModalIsOpen });
        this.handleToggleFeedback = () => this.setState({ feedbackIsOpen: !this.state.feedbackIsOpen });
        this.handleOpenUserProfile = () => {
            const baseUrl = window.location.origin;
            window.location.href = `${baseUrl}/user/profile`;
        };
        this.handleLogoLink = e => {
            if (typeof window !== 'undefined') {
                window.location.pathname === '/' && e.preventDefault();
            }
        };
    }
    render() {
        const { user } = this.props;
        const { analogSelectIsOpen, uploadSpecIsOpen, authModalIsOpen, feedbackIsOpen } = this.state;
        return (React.createElement("footer", { className: "pt-4  pt-md-5 pb-md-5 border-top" },
            React.createElement("div", { className: "container" },
                React.createElement("div", { className: "row " },
                    React.createElement("div", { className: "col-xs-12 col-sm-6 col-md-2 logo-wrapper" },
                        React.createElement("a", { href: "/", onClick: this.handleLogoLink, className: "footer-logo-link" },
                            React.createElement("object", { className: "mb-2 footer-logo-svg", type: "image/svg+xml", data: "/images/super-electrician-white.svg", style: whiteLogoStyle }, "Your browser does not support SVG")),
                        React.createElement("br", null),
                        React.createElement("a", { href: "https://legrand.ru", target: "_blank", className: "footer-logo-link" },
                            React.createElement("object", { className: "mb-2 footer-logo-svg", type: "image/svg+xml", data: "/images/legrand-logo-white.svg" }, "Your browser does not support SVG")),
                        React.createElement("small", { className: "d-block mb-3 text-muted" }, "\u00A9 Legrand. 2019 - 2020"),
                        React.createElement("a", { href: "/Consent to the processing of personal data.pdf", target: "_blank" }, "\u0421\u043E\u0433\u043B\u0430\u0448\u0435\u043D\u0438\u0435 \u043D\u0430 \u043E\u0431\u0440\u0430\u0431\u043E\u0442\u043A\u0443 \u043F\u0435\u0440\u0441\u043E\u043D\u0430\u043B\u044C\u043D\u044B\u0445 \u0434\u0430\u043D\u043D\u044B\u0445")),
                    React.createElement("div", { className: "col-xs-12 col-sm-6 col-md-2 " },
                        React.createElement("ul", { className: "list-unstyled text-small" },
                            React.createElement("li", { className: "pt-2" },
                                React.createElement("a", { href: "/project/list" }, "\u041C\u043E\u0438 \u043F\u0440\u043E\u0435\u043A\u0442\u044B")),
                            React.createElement("li", { className: "pt-2" },
                                React.createElement("a", { href: "/catalog" }, "\u041A\u0430\u0442\u0430\u043B\u043E\u0433")),
                            React.createElement("li", { className: "pt-2" },
                                React.createElement("button", { className: "legrand-footer-text-btn", onClick: user ? this.handleOpenUserProfile : this.handleToggleAuthModal }, "\u041F\u0440\u043E\u0444\u0438\u043B\u044C")))),
                    React.createElement("div", { className: "col-xs-12 col-sm-6 col-md-3" },
                        React.createElement("ul", { className: "list-unstyled text-small" },
                            user && (React.createElement("li", { className: "pt-2" },
                                React.createElement("button", { className: "legrand-footer-text-btn", onClick: this.handleUploadSpecToggle }, "\u0417\u0430\u0433\u0440\u0443\u0437\u0438\u0442\u044C \u0441\u043F\u0435\u0446\u0438\u0444\u0438\u043A\u0430\u0446\u0438\u044E"))),
                            React.createElement("li", { className: "pt-2" },
                                React.createElement("button", { className: "legrand-footer-text-btn", onClick: this.handleToggleAnalogSelect }, "\u041F\u043E\u0434\u0431\u043E\u0440 \u0430\u043D\u0430\u043B\u043E\u0433\u043E\u0432")))),
                    React.createElement("div", { className: "col-xs-12 col-sm-6 col-md-2 " },
                        React.createElement("ul", { className: "list-unstyled text-small" },
                            React.createElement("li", { className: "pt-2" },
                                React.createElement("a", { href: "/news" }, "\u041D\u043E\u0432\u043E\u0441\u0442\u0438")),
                            React.createElement("li", { className: "pt-2" },
                                React.createElement("a", { href: "/video" }, "\u0412\u0438\u0434\u0435\u043E")),
                            React.createElement("li", { className: "pt-2" },
                                React.createElement("a", { href: "/faq" }, "FAQ")))),
                    React.createElement("div", { className: "col-xs-12 col-sm-12 col-md-3 pt-sm-1" },
                        React.createElement("span", null, "\u0415\u0441\u0442\u044C \u0432\u043E\u043F\u0440\u043E\u0441\u044B, \u043F\u0440\u0435\u0434\u043B\u043E\u0436\u0435\u043D\u0438\u044F \u0438\u043B\u0438 \u043F\u043E\u0436\u0435\u043B\u0430\u043D\u0438\u044F? \u041D\u0430\u043F\u0438\u0448\u0438\u0442\u0435 \u043D\u0430\u043C."),
                        React.createElement("br", null),
                        React.createElement("button", { type: "button", className: "btn btn-info mt-3 legrand-button", onClick: this.handleToggleFeedback }, "\u041E\u0431\u0440\u0430\u0442\u043D\u0430\u044F \u0441\u0432\u044F\u0437\u044C")))),
            analogSelectIsOpen && (React.createElement(SelectionAnalog_1.default, { onClose: this.handleToggleAnalogSelect, isOpen: analogSelectIsOpen, user: user })),
            uploadSpecIsOpen && React.createElement(UploadSpec_1.default, { onClose: this.handleUploadSpecToggle, isOpen: uploadSpecIsOpen }),
            authModalIsOpen && (React.createElement(AuthRegister_1.default, { isOpen: authModalIsOpen, onClose: this.handleToggleAuthModal, defaultTab: 1 })),
            feedbackIsOpen && (React.createElement(Feedback_1.default, { isOpen: feedbackIsOpen, onClose: this.handleToggleFeedback, type: "common" }))));
    }
}
exports.Footer = Footer;
exports.default = Footer;
