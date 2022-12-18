"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : new P(function (resolve) { resolve(result.value); }).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const reducer_1 = require("./reducer");
const TabLinks_1 = require("../../ui/TabLinks");
const AddedProducts_1 = require("./components/AddedProducts");
const api_1 = require("./api");
const Icons_1 = require("../../ui/Icons/Icons");
const Dropdown_1 = require("../../ui/Dropdown");
const PageLayout_1 = require("../../components/PageLayout");
const antd_1 = require("antd");
const links = [
    {
        url: '/project/update',
        title: 'Общая информация',
        selected: false,
    },
    {
        url: '/project/products',
        title: 'Добавленная продукция',
        selected: true,
    },
    {
        url: '/project/specifications',
        title: 'Спецификация',
        selected: false,
    },
];
function ProjectProducts({ store }) {
    const [{ categories, isLoading, projectCategories, selectedCategory }, dispatch] = React.useReducer(reducer_1.reducer, {
        categories: [],
        selectedCategory: false,
        projectCategories: store.projectCategories,
        isLoading: false,
    });
    const categoriesRef = React.useRef();
    const addedProducts = React.useRef();
    React.useEffect(() => {
        dispatch({ type: 'fetch' });
        api_1.fetchProductCategories().then(response => {
            if (response.length > 0) {
                projectCategories.length > 0 &&
                    dispatch({
                        type: 'select-category',
                        payload: projectCategories[0],
                    });
            }
            dispatch({ type: 'set-categories', payload: response });
        });
    }, []);
    const addCategory = React.useCallback((item) => __awaiter(this, void 0, void 0, function* () {
        setTimeout(function () {
            categoriesRef.current.resetDropdown();
        }, 0);
        dispatch({ type: 'fetch' });
        yield api_1.addCategoryRequest({
            projectId: store.project.id,
            product_category: item.id,
        });
        const newProjectCategories = yield api_1.fetchProjectCategories(store.project.id);
        dispatch({ type: 'add-category', payload: newProjectCategories });
        dispatch({ type: 'select-category', payload: item });
        addedProducts.current && addedProducts.current.fetchDivisions(item);
    }), [projectCategories, isLoading, selectedCategory]);
    const openNotificationWithIcon = (type, message, description) => {
        antd_1.notification[type]({
            message,
            description,
        });
    };
    const handleSelectCategory = category => {
        dispatch({ type: 'select-category', payload: category });
        addedProducts.current && addedProducts.current.fetchDivisions(category);
    };
    const handleDeleteCategory = (categoryId) => {
        const projectId = store.project.id;
        api_1.deleteCategory(projectId, categoryId)
            .then(response => {
            if (response.message) {
                openNotificationWithIcon('error', 'Ошибка удаления категории', 'В категории есть добавленные товары');
            }
            else {
                const respCategories = response.data;
                dispatch({ type: 'set-project-categories', payload: respCategories });
                const selectTarget = respCategories && !!respCategories.length && respCategories[0];
                dispatch({
                    type: 'select-category',
                    payload: selectTarget,
                });
                addedProducts.current && addedProducts.current.fetchDivisions(selectTarget);
            }
        })
            .catch(err => { });
    };
    return (React.createElement("div", { className: "container mt-4 mb-3" },
        React.createElement("div", { className: "row " },
            React.createElement("div", { className: "col-md-12" },
                React.createElement(TabLinks_1.default, { id: store.project.id, links: links }))),
        React.createElement("div", { className: "row mt-3" },
            React.createElement("div", { className: "col-md-3" },
                React.createElement("ul", { className: "selected-categories" }, projectCategories.map(category => (React.createElement("li", { className: "proj-products-list-item", key: category.id },
                    React.createElement("span", { className: "proj-products-list-title", onClick: () => handleSelectCategory(category) }, category.name),
                    React.createElement("span", { className: "proj-products-list-icon", onClick: () => handleDeleteCategory(category.id) }, Icons_1.clearIcon))))),
                React.createElement("hr", null),
                React.createElement(Dropdown_1.default, { ref: categoriesRef, values: categories, isLoading: isLoading, action: addCategory, disableClear: true, defaultName: "Добавить категорию" })),
            React.createElement("div", { className: "col-md-9" }, selectedCategory && (React.createElement(AddedProducts_1.default, { ref: addedProducts, store: store, category: selectedCategory, projectId: store.project.id }))))));
}
exports.default = PageLayout_1.default(ProjectProducts);
