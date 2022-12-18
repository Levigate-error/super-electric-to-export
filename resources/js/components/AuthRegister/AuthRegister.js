"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Register_1 = require("./components/Register");
const Auth_1 = require("./components/Auth");
const Tabs_1 = require("../../ui/Tabs");
const antd_1 = require("antd");
const Icons_1 = require("../../ui/Icons/Icons");
const Restore_1 = require("./components/Restore");
const PageLayout_1 = require("../PageLayout/PageLayout");
const AuthRegister = ({ isOpen = false, onClose = () => { }, defaultTab = 1, wrapped }) => {
    const userCtx = React.useContext(PageLayout_1.UserContext);
    const [restorePassword, setRestorePassword] = React.useState(false);
    const [authVisibility, setAuthVisibility] = React.useState(false);
    const handleRestorePassword = () => setRestorePassword(true);
    const handleClose = () => {
        setAuthVisibility(false);
        onClose();
    };
    const handleCheckAuth = e => {
        const isAuth = !(Array.isArray(userCtx.userResource) && userCtx.userResource.length === 0);
        !isAuth && setAuthVisibility(true);
    };
    const tabs = [
        {
            key: '1',
            title: 'Авторизация',
            child: React.createElement(Auth_1.default, { restorePassword: handleRestorePassword, csrf: userCtx.csrf }),
        },
        {
            key: '2',
            title: 'Регистрация',
            child: React.createElement(Register_1.default, { csrf: userCtx.csrf }),
        },
    ];
    return (React.createElement(React.Fragment, null,
        wrapped && React.createElement("span", { onClick: handleCheckAuth }, wrapped),
        (isOpen || authVisibility) && !userCtx.user && (React.createElement(antd_1.Modal, { visible: isOpen || authVisibility, onCancel: handleClose, closeIcon: Icons_1.closeIcon, footer: false }, restorePassword ? React.createElement(Restore_1.default, { csrf: userCtx.csrf }) : React.createElement(Tabs_1.default, { tabs: tabs, defaultKey: defaultTab })))));
};
exports.default = AuthRegister;
