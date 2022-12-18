"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const NavBar_1 = require("../NavBar");
const Breadcrumbs_1 = require("../Breadcrumbs");
const antd_1 = require("antd");
const Button_1 = require("../../ui/Button");
const Footer_1 = require("../Footer");
exports.UserContext = React.createContext({});
const PageLayout = WrappedComponent => {
    return props => {
        return (React.createElement(exports.UserContext.Provider, { value: {
                user: props.store.user,
                userResource: props.store.userResource,
                csrf: props.store.csrf,
                recaptcha: props.store.recaptcha,
                openRegModal: props.store.openRegModal,
            } },
            React.createElement("div", { className: "top-and-content-wrapper" },
                React.createElement("div", { className: "top-bar-wrapper" },
                    React.createElement(CookieCheck, null),
                    React.createElement(NavBar_1.default, { key: "navbar", user: props.store.user, userResource: props.store.userResource, userRoles: props.store.user_roles, csrf: props.store.csrf, openRegModal: props.store.openRegModal }),
                    React.createElement(Breadcrumbs_1.default, { key: "breadcrumbs", breadcrumbs: props.store.breadcrumbs })),
                React.createElement(WrappedComponent, Object.assign({}, props, { key: "page" }))),
            React.createElement(antd_1.BackTop, null,
                React.createElement("div", { className: "ant-back-top-inner" },
                    React.createElement(antd_1.Icon, { type: "to-top" }))),
            React.createElement(Footer_1.default, { user: props.store.user })));
    };
};
exports.default = PageLayout;
const CookieCheck = () => {
    React.useEffect(() => {
        const visited = localStorage['alreadyVisited'];
        if (!visited) {
            localStorage['alreadyVisited'] = true;
            openNotification('topLeft');
        }
    }, []);
    const openNotification = placement => {
        const key = `open${Date.now()}`;
        const btn = React.createElement(Button_1.default, { onClick: () => antd_1.notification.close(key), value: "Понятно", appearance: "accent" });
        const args = {
            message: 'Использование Cookie',
            description: 'Оставаясь на сайте Вы даете согласие на использование cookies.',
            placement,
            duration: 0,
            btn,
            key,
        };
        antd_1.notification.open(args);
    };
    return React.createElement("div", null);
};
