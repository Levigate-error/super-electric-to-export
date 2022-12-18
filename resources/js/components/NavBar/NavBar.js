"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const antd_1 = require("antd");
const classnames_1 = require("classnames");
const api_1 = require("./api");
const UploadSpec_1 = require("../UploadSpec");
const SelectionAnalog_1 = require("../SelectionAnalog");
const AuthRegister_1 = require("../AuthRegister");
const Icons_1 = require("../../ui/Icons/Icons");
const { SubMenu } = antd_1.Menu;
const menuItemStyle = {
    background: 'white',
};
const submenuBtnStyle = {
    padding: 0,
};
const linkStyle = {
    paddingLeft: 7,
};
var EAuthRegister;
(function (EAuthRegister) {
    EAuthRegister[EAuthRegister["Auth"] = 1] = "Auth";
    EAuthRegister[EAuthRegister["Register"] = 2] = "Register";
})(EAuthRegister || (EAuthRegister = {}));
var EOrientation;
(function (EOrientation) {
    EOrientation[EOrientation["Horizontal"] = 1] = "Horizontal";
    EOrientation[EOrientation["Vertical"] = 2] = "Vertical";
})(EOrientation || (EOrientation = {}));
const NavBar = props => {
    const [width, setWidth] = React.useState();
    const [isVisible, setMenuVisibility] = React.useState(false);
    const [uploadSpecIsOpen, setUploadSpecVisibility] = React.useState(false);
    const [analogSelectIsOpen, setAnalogSelectVisibility] = React.useState(false);
    const [authModalIsOpen, setAuthModalIsOpen] = React.useState(false);
    const [orientation, setOrientation] = React.useState(EOrientation.Horizontal);
    // key = 1 Auth
    // key = 2 Register
    const [authOrRegister, setAuthOrRegister] = React.useState(EAuthRegister.Auth);
    const isLogined = props.userResource && !Array.isArray(props.userResource);
    const resizeWindow = React.useCallback(() => {
        setWidth(window.innerWidth);
    }, []);
    React.useEffect(() => {
        window.addEventListener('resize', resizeWindow);
        return () => {
            window.removeEventListener('resize', resizeWindow);
        };
    }, []);
    React.useEffect(() => {
        resizeWindow();
        setOrientation(width >= 991 ? EOrientation.Horizontal : EOrientation.Vertical);
    }, [width]);
    React.useEffect(() => {
        if (props.openRegModal && !isLogined) {
            setAuthOrRegister(EAuthRegister.Register);
            setAuthModalIsOpen(true);
        }
    }, [props.openRegModal, isLogined]);
    const toggleVisibility = () => setMenuVisibility(!isVisible);
    const handleCreateProject = () => {
        const base_url = window.location.origin;
        api_1.createProject().then(response => {
            document.location.href = base_url + '/project/update/' + response.data.id;
        });
    };
    const handleLogout = () => {
        const base_url = window.location.origin;
        api_1.logout(props.csrf).then(response => {
            document.location.href = base_url;
        });
    };
    const handleOpenUploadSpec = () => setUploadSpecVisibility(true);
    const handleCloseUploadSpec = () => setUploadSpecVisibility(false);
    const handleOpenAnalogSelect = () => setAnalogSelectVisibility(true);
    const handleCloseAnalogSelect = () => setAnalogSelectVisibility(false);
    const handleOpenAuthModal = () => {
        setAuthOrRegister(EAuthRegister.Auth);
        setAuthModalIsOpen(true);
    };
    const handleColseAuthModal = () => setAuthModalIsOpen(false);
    const handleOpenRegisterModal = () => {
        setAuthOrRegister(EAuthRegister.Register);
        setAuthModalIsOpen(true);
    };
    const isVertical = orientation === EOrientation.Vertical;
    const handleLogoLink = e => {
        if (typeof window !== 'undefined') {
            window.location.pathname === '/' && e.preventDefault();
        }
    };
    return (React.createElement("div", { className: classnames_1.default('navbar-wrapper', {
            'vertical-orientation': isVertical,
        }) },
        React.createElement("div", { className: "container" },
            React.createElement("nav", { className: classnames_1.default('legrand-navbar', {
                    'vertical-orientation': isVertical,
                }) },
                React.createElement("div", { className: "navbar-logo-wrapper" },
                    React.createElement("a", { className: "navbar-brand ", href: "/", onClick: handleLogoLink }, Icons_1.superElectricianLogo)),
                orientation === EOrientation.Vertical && (React.createElement(antd_1.Icon, { type: "menu", onClick: toggleVisibility, className: "menu-colapse-icon" })),
                (orientation === EOrientation.Horizontal || isVisible) && (React.createElement(antd_1.Menu, { mode: orientation === EOrientation.Horizontal ? 'horizontal' : 'inline' },
                    React.createElement(antd_1.Menu.Item, { key: "projects" },
                        React.createElement("a", { href: "/project/list" }, "\u041C\u043E\u0438 \u043F\u0440\u043E\u0435\u043A\u0442\u044B")),
                    React.createElement(SubMenu, { key: "tools", title: React.createElement("span", { className: "with-icon-title-wrapper" },
                            "\u0418\u043D\u0441\u0442\u0440\u0443\u043C\u0435\u043D\u0442\u044B",
                            React.createElement(antd_1.Icon, { type: "down" })) },
                        isLogined && (React.createElement(antd_1.Menu.Item, { key: "setting:1", className: "menu-subitem", style: menuItemStyle },
                            React.createElement("button", { onClick: handleOpenUploadSpec, style: submenuBtnStyle }, "\u0417\u0430\u0433\u0440\u0443\u0437\u0438\u0442\u044C \u0441\u043F\u0435\u0446\u0438\u0444\u0438\u043A\u0430\u0446\u0438\u044E"))),
                        React.createElement(antd_1.Menu.Item, { key: "setting:2", className: "menu-subitem", style: menuItemStyle },
                            React.createElement("button", { onClick: handleOpenAnalogSelect, style: submenuBtnStyle }, "\u041F\u043E\u0434\u0431\u043E\u0440 \u0430\u043D\u0430\u043B\u043E\u0433\u043E\u0432"))),
                    React.createElement(antd_1.Menu.Item, { key: "catalog" },
                        React.createElement("a", { href: "/catalog" }, "\u041A\u0430\u0442\u0430\u043B\u043E\u0433")),
                    React.createElement(antd_1.Menu.Item, { key: "where_to_buy" },
                        React.createElement("a", { href: "https://legrand.ru/where/map", target: "_blank" }, "\u0413\u0434\u0435 \u043A\u0443\u043F\u0438\u0442\u044C")),
                    React.createElement(SubMenu, { key: "blog", title: React.createElement("span", { className: "with-icon-title-wrapper" },
                            "\u0411\u043B\u043E\u0433",
                            React.createElement(antd_1.Icon, { type: "down" })) },
                        React.createElement(antd_1.Menu.Item, { key: "setting:7", className: "menu-subitem", style: menuItemStyle },
                            React.createElement("a", { href: "/news", className: "legweb-text-btn" }, "\u041D\u043E\u0432\u043E\u0441\u0442\u0438")),
                        React.createElement(antd_1.Menu.Item, { key: "setting:6", className: "menu-subitem", style: menuItemStyle },
                            React.createElement("a", { href: "/video", className: "legweb-text-btn" }, "\u0412\u0438\u0434\u0435\u043E")),
                        React.createElement(antd_1.Menu.Item, { key: "setting:8", className: "menu-subitem", style: menuItemStyle },
                            React.createElement("a", { href: "https://legrand.ru/services/learning", target: "_blank", className: "legweb-text-btn" }, "\u0417\u0430\u043F\u0438\u0441\u0430\u0442\u044C\u0441\u044F \u043D\u0430 \u043E\u0431\u0443\u0447\u0435\u043D\u0438\u0435"))),
                    React.createElement(antd_1.Menu.Item, { key: "help" },
                        React.createElement("a", { href: "/faq" }, "\u041F\u043E\u043C\u043E\u0449\u044C")),
                    isLogined
                        ? [
                            React.createElement(SubMenu, { key: "user-menu", title: React.createElement("span", { className: "with-icon-title-wrapper" },
                                    React.createElement("div", { className: "navbar-name-wrapper" }, props.userResource.first_name),
                                    React.createElement(antd_1.Icon, { type: "down" })) },
                                React.createElement(antd_1.Menu.Item, { key: "setting:3", className: "menu-subitem", style: menuItemStyle },
                                    React.createElement("a", { href: "/user/profile", style: linkStyle, className: "navbar-link" }, "\u041C\u043E\u0439 \u043F\u0440\u043E\u0444\u0438\u043B\u044C")),
                                React.createElement(antd_1.Menu.Item, { key: "setting:4", className: "menu-subitem", style: menuItemStyle },
                                    React.createElement("a", { href: "/loyalty-program", style: linkStyle, className: "navbar-link" }, "\u041F\u0440\u043E\u0433\u0440\u0430\u043C\u043C\u0430 \u043B\u043E\u044F\u043B\u044C\u043D\u043E\u0441\u0442\u0438 Netatmo")),
                                React.createElement(antd_1.Menu.Item, { key: "setting:5", className: "menu-subitem", style: menuItemStyle },
                                    React.createElement("a", { href: "/inspiria", style: linkStyle, className: "navbar-link" }, "\u041F\u0440\u043E\u0433\u0440\u0430\u043C\u043C\u0430 \u043B\u043E\u044F\u043B\u044C\u043D\u043E\u0441\u0442\u0438 Inspiria")),
                                React.createElement(antd_1.Menu.Item, { key: "setting:6", className: "menu-subitem", style: menuItemStyle },
                                    React.createElement("button", { onClick: handleLogout }, "\u0412\u044B\u0439\u0442\u0438"))),
                        ]
                        : [
                            React.createElement(antd_1.Menu.Item, { key: "login", style: menuItemStyle },
                                React.createElement("button", { className: "legrand-btn btn-second ", onClick: handleOpenAuthModal }, "\u0412\u043E\u0439\u0442\u0438")),
                            React.createElement(antd_1.Menu.Item, { key: "register", style: menuItemStyle },
                                React.createElement("button", { className: "legrand-btn btn-accent ", onClick: handleOpenRegisterModal }, "\u0420\u0435\u0433\u0438\u0441\u0442\u0440\u0430\u0446\u0438\u044F")),
                        ],
                    isLogined && props.userResource.roles.find(el => el.slug === 'electrician') && (React.createElement(antd_1.Menu.Item, { key: "create-project", style: menuItemStyle },
                        React.createElement("button", { onClick: handleCreateProject, className: "legrand-btn btn-accent" }, "\u0421\u043E\u0437\u0434\u0430\u0442\u044C \u043F\u0440\u043E\u0435\u043A\u0442")))))),
            uploadSpecIsOpen && React.createElement(UploadSpec_1.default, { onClose: handleCloseUploadSpec, isOpen: uploadSpecIsOpen }),
            analogSelectIsOpen && (React.createElement(SelectionAnalog_1.default, { onClose: handleCloseAnalogSelect, isOpen: analogSelectIsOpen, user: props.userResource })),
            authModalIsOpen && (React.createElement(AuthRegister_1.default, { isOpen: authModalIsOpen, onClose: handleColseAuthModal, defaultTab: authOrRegister })))));
};
exports.default = NavBar;
