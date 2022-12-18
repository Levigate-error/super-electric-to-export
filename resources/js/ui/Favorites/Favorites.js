"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const classnames_1 = require("classnames");
const Icons_1 = require("../Icons/Icons");
function FavoritesButton(props) {
    const { isActive, action, disabled } = props;
    return (React.createElement("button", { title: "Избранное", disabled: disabled, className: classnames_1.default("favorites-marker", {
            "favorite-active": isActive
        }), onClick: action }, Icons_1.favoriteIcon));
}
exports.default = React.memo(FavoritesButton);
