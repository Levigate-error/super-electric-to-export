"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const PageLayout_1 = require("../../../../components/PageLayout/PageLayout");
const AuthRegister_1 = require("../../../../components/AuthRegister");
const Favorites_1 = require("../../../../ui/Favorites");
const reducer_1 = require("./reducer");
const api_1 = require("../Recommended/api");
const errorImageStyle = {
    background: 'url(/images/default_product.jpg) no-repeat center center',
    backgroundSize: 'cover',
};
const normalImageStyle = {
    background: 'none',
};
const Product = ({ product: { id, name, attributes, is_favorites, img, vendor_code }, }) => {
    const [{ isFavorites, isLoading, imgError }, dispatch] = React.useReducer(reducer_1.reducer, {
        isFavorites: is_favorites,
        isLoading: false,
        imgError: false,
    });
    const setDeafultImage = () => {
        dispatch({ type: reducer_1.actionTypes.IMG_ERROR });
    };
    const userCtx = React.useContext(PageLayout_1.UserContext);
    const handleToggleFavoriteButton = React.useCallback(() => {
        if (userCtx.user) {
            dispatch({ type: reducer_1.actionTypes.FAVORITES_REQUEST });
            if (!isFavorites) {
                api_1.addToFavorites(id).then(response => {
                    const { data: { error }, } = response;
                    if (!error) {
                        dispatch({ type: reducer_1.actionTypes.ADD_TO_FAVORITES });
                    }
                });
            }
            else {
                api_1.removeFromFavorites(id).then(response => {
                    const { data: { error }, } = response;
                    if (!error) {
                        dispatch({ type: reducer_1.actionTypes.REMOVE_FROM_FAVORITES });
                    }
                });
            }
        }
    }, [isFavorites, isLoading]);
    const imgStyle = imgError ? errorImageStyle : normalImageStyle;
    return (React.createElement("div", { className: "product-wrapper" },
        React.createElement("div", { className: "product" },
            React.createElement("div", { className: "product-photo", style: imgStyle },
                React.createElement("div", { className: "favorites-button-wrapper" },
                    React.createElement(AuthRegister_1.default, { wrapped: React.createElement(Favorites_1.FavoritesButton, { disabled: isLoading, isActive: isFavorites, action: handleToggleFavoriteButton }) })),
                React.createElement("a", { href: `catalog/product/${id}` }, !imgError && React.createElement("img", { src: img, alt: name, onError: setDeafultImage }))),
            React.createElement("a", { href: `catalog/product/${id}`, className: "product-title", title: name }, name),
            React.createElement("span", { className: "product-vendor-code" },
                "\u0410\u0440\u0442. ",
                vendor_code),
            React.createElement(ProductParams, { attributes: attributes }))));
};
exports.default = Product;
const ProductParams = ({ attributes }) => {
    return (React.createElement("ul", { className: "product-params mt-3" }, attributes.slice(0, 5).map(item => (React.createElement("li", { className: "product-param-row mt-2", key: item.title },
        React.createElement("span", null,
            item.title,
            ":"),
        React.createElement("span", null, item.value))))));
};
