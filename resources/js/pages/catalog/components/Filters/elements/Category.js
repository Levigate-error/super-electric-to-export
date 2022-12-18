"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Subcategories_1 = require("./Subcategories");
const Icons_1 = require("../../../../../ui/Icons/Icons");
function Category({ name, values, selectFilter, checkedFilters, categoryId }) {
    const [isVisible, setIsVisible] = React.useState(false);
    const handleClick = React.useCallback(() => {
        setIsVisible(!isVisible);
    }, [isVisible]);
    return (React.createElement("div", { className: "filter-category" },
        React.createElement("div", { className: "category", onClick: handleClick },
            React.createElement("span", null, name),
            React.createElement("span", null, isVisible ? Icons_1.chevronUp : Icons_1.chevronDown)),
        React.createElement(Subcategories_1.default, { isVisible: isVisible, categoryId: categoryId, selectFilter: selectFilter, values: values, checkedFilters: checkedFilters })));
}
exports.default = React.memo(Category);
