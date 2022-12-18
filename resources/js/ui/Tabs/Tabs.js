"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const antd_1 = require("antd");
const { TabPane } = antd_1.Tabs;
const TabsComponent = ({ tabs = [], onSelect, defaultKey = 1 }) => {
    return (React.createElement(antd_1.Tabs, { defaultActiveKey: `${defaultKey}`, onChange: onSelect }, tabs.map(tab => (React.createElement(TabPane, { tab: tab.title, key: tab.key }, tab.child)))));
};
exports.default = TabsComponent;
