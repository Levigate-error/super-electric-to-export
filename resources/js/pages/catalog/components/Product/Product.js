"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const classnames_1 = require("classnames");
const Favorites_1 = require("../../../../ui/Favorites");
const ProductParams_1 = require("./elements/ProductParams");
const api_1 = require("./api");
const Button_1 = require("../../../../ui/Button");
const Modal_1 = require("../../../../ui/Modal");
const AuthRegister_1 = require("../../../../components/AuthRegister");
const AddProduct_1 = require("../../../../ui/AddProduct");
const Spinner_1 = require("../../../../ui/Spinner");
const PageLayout_1 = require("../../../../components/PageLayout/PageLayout");
function reducer(state, action) {
    switch (action.type) {
        case 'favoritesRequest':
            return Object.assign({}, state, { isLoading: true });
        case 'addToFavorites':
            return Object.assign({}, state, { isFavorites: true, isLoading: false });
        case 'removeFromFavorites':
            return Object.assign({}, state, { isFavorites: false, isLoading: false });
        case 'imgLoadingError':
            return Object.assign({}, state, { imgError: true });
        case 'open-add-modal':
            return Object.assign({}, state, { addModalIsVisible: true, addModalLoading: true, projects: [] });
        case 'set-projects':
            return Object.assign({}, state, { projects: action.payload, addModalLoading: false });
        case 'close-add-modal':
            return Object.assign({}, state, { addModalIsVisible: false, addModalLoading: false });
        default:
            return state;
    }
}
const addSpinerStyle = {
    height: 100,
    width: '100%',
    display: 'flex',
    justifyContent: 'center',
};
const errorImageStyle = {
    background: 'url(images/default_product.jpg) no-repeat center center',
    backgroundSize: 'cover',
};
const normalImageStyle = {
    background: 'none',
};
function Product({ product, showAsRows }) {
    const [{ isFavorites, isLoading, imgError, addModalIsVisible, addModalLoading, projects }, dispatch,] = React.useReducer(reducer, {
        isFavorites: product.is_favorites,
        isLoading: false,
        imgError: false,
        addModalIsVisible: false,
        addModalLoading: false,
        projects: [],
    });
    const userCtx = React.useContext(PageLayout_1.UserContext);
    const handleToggleFavoriteButton = React.useCallback(() => {
        if (userCtx.user) {
            dispatch({ type: 'favoritesRequest' });
            if (!isFavorites) {
                api_1.addToFavorites(product.id).then(response => {
                    const { data: { error }, } = response;
                    if (!error) {
                        dispatch({ type: 'addToFavorites' });
                    }
                });
            }
            else {
                api_1.removeFromFavorites(product.id).then(response => {
                    const { data: { error }, } = response;
                    if (!error) {
                        dispatch({ type: 'removeFromFavorites' });
                    }
                });
            }
        }
    }, [isFavorites, isLoading]);
    const setDeafultImage = () => {
        dispatch({ type: 'imgLoadingError' });
    };
    const handleOpenModal = React.useCallback(() => {
        dispatch({ type: 'open-add-modal' });
        api_1.getProjects().then(response => dispatch({ type: 'set-projects', payload: response.data.projects }));
    }, [addModalIsVisible, addModalLoading, projects]);
    const handleCloseModal = () => {
        dispatch({ type: 'close-add-modal' });
    };
    const imgStyle = imgError ? errorImageStyle : normalImageStyle;
    const modalContent = !addModalLoading ? (React.createElement(AddProduct_1.default, { projects: projects, productId: product.id, closeModal: handleCloseModal, userResource: userCtx.userResource })) : (React.createElement(Spinner_1.default, { style: addSpinerStyle }));
    return (React.createElement("div", { className: "product-wrapper" },
        addModalIsVisible && (React.createElement(Modal_1.default, { onClose: handleCloseModal, isOpen: addModalIsVisible, children: modalContent })),
        React.createElement("div", { className: "product" },
            React.createElement("div", { className: "product-photo", style: imgStyle },
                React.createElement("div", { className: "favorites-button-wrapper" },
                    React.createElement(AuthRegister_1.default, { wrapped: React.createElement(Favorites_1.FavoritesButton, { disabled: isLoading, isActive: isFavorites, action: handleToggleFavoriteButton }) })),
                React.createElement("a", { href: `catalog/product/${product.id}` }, !imgError && React.createElement("img", { src: product.img, alt: product.name, onError: setDeafultImage }))),
            React.createElement("a", { href: `catalog/product/${product.id}`, className: "product-title", title: product.name }, product.name),
            React.createElement("span", { className: "product-vendor-code" },
                "\u0410\u0440\u0442. ",
                product.vendor_code),
            React.createElement(ProductParams_1.ProductParams, { params: product.attributes })),
        React.createElement("span", { className: "catalog-product-cost" },
            product.recommended_retail_price,
            " \u20BD"),
        React.createElement(Button_1.default, { onClick: handleOpenModal, appearance: "accent", value: "Добавить", className: classnames_1.default(showAsRows ? 'product-row-btn' : 'product-grid-btn') })));
}
exports.default = React.memo(Product);
