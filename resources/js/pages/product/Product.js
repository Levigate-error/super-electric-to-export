"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Slider_1 = require("./components/Slider");
const Attributes_1 = require("./components/Attributes");
const Instructions_1 = require("./components/Instructions");
const Videos_1 = require("./components/Videos");
const react_tabs_1 = require("react-tabs");
const PageLayout_1 = require("../../components/PageLayout/PageLayout");
const Button_1 = require("../../ui/Button");
const Modal_1 = require("../../ui/Modal");
const AddProduct_1 = require("../../ui/AddProduct");
const Spinner_1 = require("../../ui/Spinner");
const api_1 = require("./api");
const PageLayout_2 = require("../../components/PageLayout");
const AuthRegister_1 = require("../../components/AuthRegister");
const Favorites_1 = require("../../ui/Favorites");
const Recommended_1 = require("./components/Recommended");
const ByWithThis_1 = require("./components/ByWithThis");
function reducer(state, action) {
    switch (action.type) {
        case 'open-add-modal':
            return Object.assign({}, state, { addModalIsVisible: true, addModalLoading: true, projects: [] });
        case 'set-projects':
            return Object.assign({}, state, { projects: action.payload, addModalLoading: false });
        case 'close-add-modal':
            return Object.assign({}, state, { addModalIsVisible: false, addModalLoading: false });
        case 'favorites-request':
            return Object.assign({}, state, { isFavorites: false, isLoading: true });
        case 'add-to-favorites':
            return Object.assign({}, state, { isFavorites: true, isLoading: false });
        case 'remove-from-favorites':
            return Object.assign({}, state, { isFavorites: false, isLoading: false });
        default:
            throw new Error();
    }
}
const addSpinerStyle = {
    margin: '0 auto',
};
function Product({ store: { id, name, is_favorites, description, family, attributes, images, instructions, vendor_code, videos, recommended_retail_price, userResource, user, }, }) {
    const [{ addModalIsVisible, addModalLoading, projects, isLoading, isFavorites }, dispatch] = React.useReducer(reducer, {
        addModalIsVisible: false,
        addModalLoading: false,
        isFavorites: is_favorites,
        isLoading: false,
        projects: [],
    });
    const userCtx = React.useContext(PageLayout_1.UserContext);
    const discriptionIsVisible = description !== '';
    const attributesIsVisible = !!attributes.length;
    const instructionsIsVisible = !!instructions.length;
    const videosIsVisible = !!videos.length;
    const handleOpenModal = React.useCallback(() => {
        dispatch({ type: 'open-add-modal' });
        api_1.getProjects().then(response => dispatch({ type: 'set-projects', payload: response.data.projects }));
    }, [addModalIsVisible, addModalLoading, projects]);
    const handleToggleFavoriteButton = React.useCallback(() => {
        if (userCtx.user) {
            dispatch({ type: 'favorites-request' });
            if (!isFavorites) {
                api_1.addToFavorites(id).then(response => {
                    const { data: { error }, } = response;
                    if (!error) {
                        dispatch({ type: 'add-to-favorites' });
                    }
                });
            }
            else {
                api_1.removeFromFavorites(id).then(response => {
                    const { data: { error }, } = response;
                    if (!error) {
                        dispatch({ type: 'remove-from-favorites' });
                    }
                });
            }
        }
    }, [isFavorites, isLoading]);
    const handleCloseModal = () => {
        dispatch({ type: 'close-add-modal' });
    };
    const modalContent = !addModalLoading ? (React.createElement(AddProduct_1.default, { projects: projects, productId: id, closeModal: handleCloseModal, userResource: userCtx.userResource })) : (React.createElement(Spinner_1.default, { style: addSpinerStyle }));
    let lastProjectActivity = false;
    if (!Array.isArray(userResource)) {
        const project = userResource.activities.project;
        if (!Array.isArray(project)) {
            lastProjectActivity = project;
        }
    }
    const goToLastProject = id => {
        const base_url = window.location.origin;
        document.location.href = `${base_url}/project/specifications/${id}`;
    };
    return (React.createElement(React.Fragment, null,
        addModalIsVisible && (React.createElement(Modal_1.default, { onClose: handleCloseModal, isOpen: addModalIsVisible, children: modalContent })),
        React.createElement("div", { className: "container product-detail-wrapper" },
            React.createElement("div", { className: "row " },
                React.createElement("div", { className: "col-md-5" },
                    React.createElement(Slider_1.default, { imagesData: images })),
                React.createElement("div", { className: "col-md-7" },
                    React.createElement("div", { className: "row" },
                        React.createElement("div", { className: "col-md-12" },
                            React.createElement("h1", { className: "product-title" }, name),
                            React.createElement("div", { className: "favorites-button-wrapper" },
                                React.createElement(AuthRegister_1.default, { wrapped: React.createElement(Favorites_1.FavoritesButton, { disabled: isLoading, isActive: isFavorites, action: handleToggleFavoriteButton }) })))),
                    React.createElement("div", { className: "row  mt-3" },
                        React.createElement("div", { className: "col-md-12" },
                            React.createElement("span", { className: "product-vendor-code" },
                                "\u0410\u0440\u0442\u0438\u043A\u0443\u043B: ",
                                vendor_code))),
                    React.createElement("div", { className: "row  mt-1" },
                        React.createElement("div", { className: "col-md-12" },
                            React.createElement("span", { className: "series-wrapper" },
                                "\u0421\u0435\u0440\u0438\u044F: ",
                                family.name))),
                    React.createElement("div", { className: "row  mt-1" },
                        React.createElement("div", { className: "col-md-12" },
                            React.createElement("span", { className: "price-wrapper" },
                                "\u0420\u0435\u043A\u043E\u043C\u0435\u043D\u0434\u0443\u0435\u043C\u0430\u044F \u0440\u043E\u0437\u043D\u0438\u0447\u043D\u0430\u044F \u0446\u0435\u043D\u0430:",
                                React.createElement("span", null,
                                    recommended_retail_price,
                                    " \u20BD")))),
                    React.createElement("div", { className: "row mt-3" },
                        React.createElement("div", { className: "col-md-6" },
                            React.createElement(Button_1.default, { onClick: handleOpenModal, value: "Добавить" }))),
                    React.createElement("div", { className: "row mt-3" },
                        React.createElement("div", { className: "col-md-6" }, user && !!lastProjectActivity && (React.createElement("button", { onClick: () => goToLastProject(lastProjectActivity.source_id), className: "legrand-text-btn back-to-proj-btn" }, "\u2190 \u0412\u0435\u0440\u043D\u0443\u0442\u0441\u044F \u0432 \u043F\u0440\u043E\u0435\u043A\u0442"))))))),
        (discriptionIsVisible || attributesIsVisible || instructionsIsVisible || videosIsVisible) && (React.createElement("div", { className: "container-fluid product-info-wrpapper" },
            React.createElement("div", { className: "container" },
                React.createElement("div", { className: "row mt-3 " },
                    React.createElement("div", { className: "col-md-12" },
                        React.createElement(react_tabs_1.Tabs, { className: "product-tabs" },
                            React.createElement(react_tabs_1.TabList, { className: "tabs-ul" },
                                discriptionIsVisible && React.createElement(react_tabs_1.Tab, { className: "tabs-menu-item" }, "\u041E \u0442\u043E\u0432\u0430\u0440\u0435"),
                                attributesIsVisible && React.createElement(react_tabs_1.Tab, { className: "tabs-menu-item" }, "\u0425\u0430\u0440\u0430\u043A\u0442\u0435\u0440\u0438\u0441\u0442\u0438\u043A\u0438"),
                                instructionsIsVisible && React.createElement(react_tabs_1.Tab, { className: "tabs-menu-item" }, "\u0418\u043D\u0441\u0442\u0440\u0443\u043A\u0446\u0438\u0438"),
                                videosIsVisible && React.createElement(react_tabs_1.Tab, { className: "tabs-menu-item" }, "\u0412\u0438\u0434\u0435\u043E")),
                            discriptionIsVisible && (React.createElement(react_tabs_1.TabPanel, null,
                                React.createElement("h3", null, "\u041E\u043F\u0438\u0441\u0430\u043D\u0438\u0435:"),
                                React.createElement("p", null, description))),
                            attributesIsVisible && (React.createElement(react_tabs_1.TabPanel, null,
                                React.createElement("div", { className: "tabs-content-item" },
                                    React.createElement(Attributes_1.default, { atrributes: attributes })))),
                            instructionsIsVisible && (React.createElement(react_tabs_1.TabPanel, null,
                                React.createElement("div", { className: "tabs-content-item" },
                                    React.createElement(Instructions_1.default, { instructions: instructions })))),
                            videosIsVisible && (React.createElement(react_tabs_1.TabPanel, null,
                                React.createElement("div", { className: "tabs-content-item" },
                                    React.createElement(Videos_1.default, { videos: videos })))))))))),
        React.createElement("div", { className: "container " },
            React.createElement("div", { className: "row" },
                React.createElement("div", { className: "col-12" },
                    React.createElement(ByWithThis_1.default, { productId: id })))),
        React.createElement("div", { className: "container product-detail-last-section" },
            React.createElement("div", { className: "row" },
                React.createElement("div", { className: "col-12" },
                    React.createElement(Recommended_1.default, null))))));
}
exports.default = PageLayout_2.default(React.memo(Product));
