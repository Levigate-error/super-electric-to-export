"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const PageLayout_1 = require("../../components/PageLayout");
const Collection_1 = require("./components/Collection");
const Info_1 = require("./components/Info");
const Join_1 = require("./components/Join");
const Navbar_1 = require("./components/Navbar");
const Prize_1 = require("./components/Prize");
const Question_1 = require("./components/Question");
const Range_1 = require("./components/Range");
const Rules_1 = require("./components/Rules");
const Promo = props => {
    return (React.createElement("div", { className: "promo" },
        React.createElement(Navbar_1.default, { user: props.store.user }),
        React.createElement(Info_1.default, null),
        React.createElement(Collection_1.default, null),
        React.createElement(Range_1.default, null),
        React.createElement(Rules_1.default, null),
        React.createElement(Prize_1.default, null),
        React.createElement(Join_1.default, { user: props.store.user }),
        React.createElement(Question_1.default, null)));
};
exports.default = PageLayout_1.default(Promo);
