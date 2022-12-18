"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const lodash_1 = require("lodash");
const react_drag_and_drop_1 = require("react-drag-and-drop");
const Modal_1 = require("../../../../../../ui/Modal");
const Button_1 = require("../../../../../../ui/Button");
const Input_1 = require("../../../../../../ui/Input");
const Checkbox_1 = require("../../../../../../ui/Checkbox");
const Dropdown_1 = require("../../../../../../ui/Dropdown");
const antd_1 = require("antd");
const TableInput_1 = require("./TableInput");
const api_1 = require("./api");
const DraggbleRow = row => {
    return (React.createElement(react_drag_and_drop_1.Draggable, { type: "row", data: `${row.record.id}_${row.record.section}_${row.record.amount}_${row.record.section_product_id}`, key: row.record.id, className: "draggble-table-row" }, row.children));
};
const checkboxVIsibility = false;
class SpecTable extends React.Component {
    constructor() {
        super(...arguments);
        this.state = {
            moveModalIsVisible: false,
            productCount: 0,
            currentProductId: false,
            currentProductAmount: 0,
            currentSectionId: false,
            targetSection: this.props.section,
            moveProductLoading: false,
        };
        this.selectTargetRef = React.createRef();
        this.components = {
            body: {
                row: DraggbleRow,
            },
        };
        this.columns = [
            {
                title: this.props.section.title,
                dataIndex: 'name',
                key: 'name',
                width: 250,
                ellipsis: true,
                render: (text, row, index) => {
                    const { section: { fake_section }, } = this.props;
                    const menu = (React.createElement(antd_1.Menu, { className: "spec-context-menu" },
                        React.createElement(antd_1.Menu.Item, null,
                            React.createElement("button", { className: "spec-context-menu-btn", onClick: () => this.handleMoveProductButton(row) }, "\u041F\u0435\u0440\u0435\u043D\u0435\u0441\u0442\u0438")),
                        React.createElement(antd_1.Menu.Item, null, fake_section ? (React.createElement("button", { onClick: () => this.handleDeleteProjectProduct(row.id) }, "\u0423\u0434\u0430\u043B\u0438\u0442\u044C")) : (React.createElement("button", { onClick: () => this.handleDeleteSectionProduct(row.section_product_id) }, "\u0423\u0431\u0440\u0430\u0442\u044C \u0438\u0437 \u0440\u0430\u0437\u0434\u0435\u043B\u0430")))));
                    return {
                        children: (React.createElement("div", { className: "spec-table-name-wrapper" },
                            React.createElement(antd_1.Dropdown, { overlay: menu, className: "spec-context-menu-item" },
                                React.createElement(antd_1.Icon, { type: "menu" })),
                            checkboxVIsibility && (React.createElement("div", { className: "spec-table-check-wrapper" },
                                React.createElement(Checkbox_1.default, { checked: row.active, onChange: value => {
                                        this.handleChangeActive(value, row);
                                    } }))),
                            React.createElement("span", null, text))),
                    };
                },
            },
            {
                title: 'Скидка',
                dataIndex: 'discount',
                key: 'discount',
                width: 100,
                render: (text, row, index) => {
                    return {
                        children: !this.props.isLoading && (React.createElement(TableInput_1.default, { type: "number", value: text, minMax: { min: 0, max: 100 }, onChange: value => {
                                this.handleChangeDiscountValue(value, row);
                            }, disabled: this.props.isLoading })),
                    };
                },
            },
            {
                title: 'В наличии',
                dataIndex: 'in_stock',
                key: 'in_stock',
                width: 95,
                render: (value, row, index) => (value ? 'Да' : 'Нет'),
            },
            {
                title: 'Артикул',
                dataIndex: 'vendor_code',
                key: 'vendor_code',
                width: 85,
            },
            {
                title: 'Кол-во',
                dataIndex: 'amount',
                key: 'amount',
                width: 100,
                render: (text, row, index) => {
                    return {
                        children: !this.props.isLoading && (React.createElement(TableInput_1.default, { type: "number", value: text, minMax: { min: 1, max: 999 }, onChange: value => {
                                this.handleChangeAmountValue(value, row);
                            }, disabled: this.props.isLoading })),
                    };
                },
            },
            {
                title: 'Цена',
                dataIndex: 'price',
                key: 'price',
                width: 90,
            },
            {
                title: 'Стоимость',
                dataIndex: 'total_price',
                key: 'total_price',
                width: 110,
            },
        ];
        this.handleMoveProductButton = row => {
            const { sections, section } = this.props;
            const targetSection = sections.find(el => !el.fake_section && el.id !== section.id);
            if (targetSection) {
                this.selectTargetRef.current.handleClick(targetSection);
                this.setState({
                    moveModalIsVisible: true,
                    currentProductId: row.section_product_id || row.id,
                    currentSectionId: row.section,
                    currentProductAmount: row.amount,
                    productCount: row.amount,
                    targetSection,
                });
            }
            else {
                this.openNotificationWithIcon('error', 'Нельзя перенести продукт', 'Вы еще не создали разделы спецификации');
            }
        };
        this.openNotificationWithIcon = (type, message, description) => {
            antd_1.notification[type]({
                message,
                description,
            });
        };
        this.handleDeleteProjectProduct = product_id => {
            const { projectId, specification, updateSpec } = this.props;
            api_1.deleteProductFromProject(projectId, product_id).then(response => {
                if (response.message) {
                    this.openNotificationWithIcon('error', 'Нельзя удалить из проекта', response.message);
                }
                updateSpec(specification.id);
            });
        };
        this.handleDeleteSectionProduct = specification_product_id => {
            const { specification, updateSpec } = this.props;
            api_1.deleteProductFromSection(specification.id, specification_product_id).then(response => {
                if (response.message) {
                    this.openNotificationWithIcon('error', 'Нельзя удалить продукт', response.message);
                }
                updateSpec(specification.id);
            });
        };
        // CHANGE ACTIVE
        //--------------------------------------------------------------------------
        this.handleChangeActive = (value, row) => {
            const { specification, projectId, updateSpec, section: { fake_section }, } = this.props;
            if (fake_section) {
                const params = {
                    active: !row.active,
                };
                api_1.projectProductUpdate({
                    project_id: projectId,
                    product_id: row.id,
                }, params).then(response => {
                    if (response.message) {
                        this.openNotificationWithIcon('error', 'Ошибка обновления продукта', response.message);
                    }
                    response.data.result && updateSpec(specification.id);
                });
            }
            else {
                const params = {
                    specification_id: specification.id,
                    section_product_id: row.section_product_id,
                    active: value ? 1 : 0,
                };
                api_1.updateSpecProductActive(params).then(response => {
                    if (response.message) {
                        this.openNotificationWithIcon('error', 'Ошибка обновления продукта', response.message);
                    }
                    updateSpec(specification.id);
                });
            }
        };
        //--------------------------------------------------------------------------
        // CHANGE DISCOUNT
        //--------------------------------------------------------------------------
        this.handleChangeDiscountValue = lodash_1.debounce((value = 0, row) => {
            const { specification, projectId, updateSpec, section: { fake_section }, } = this.props;
            const intValue = parseInt(value.toString());
            const discount = intValue <= 0 ? 0 : intValue;
            if (fake_section) {
                const params = {
                    discount,
                };
                api_1.projectProductUpdate({
                    project_id: projectId,
                    product_id: row.id,
                }, params).then(response => {
                    if (response.message) {
                        this.openNotificationWithIcon('error', 'Ошибка обновления продукта', response.message);
                    }
                    response.data.result && updateSpec(specification.id);
                });
            }
            else {
                this.handleUpdateSpecProductDiscount({
                    discount,
                    section_product_id: row.section_product_id,
                });
            }
        }, 600);
        this.handleUpdateSpecProductDiscount = ({ discount, section_product_id }) => {
            const { specification, updateSpec } = this.props;
            const params = {
                specification_id: specification.id,
                section_product_id,
                discount,
            };
            (!!discount || discount === 0) &&
                api_1.updateSpecProductDiscount(params).then(response => {
                    if (response.message) {
                        this.openNotificationWithIcon('error', 'Ошибка обновления продукта', response.message);
                    }
                    updateSpec(specification.id);
                });
        };
        //--------------------------------------------------------------------------
        // CHANGE AMOUNT
        //--------------------------------------------------------------------------
        this.handleChangeAmountValue = lodash_1.debounce((value, row) => {
            const { projectId, specification, updateSpec, section: { fake_section }, } = this.props;
            const intValue = parseInt(value);
            const amount = intValue <= 0 ? 1 : intValue;
            if (fake_section) {
                const params = {
                    amount,
                };
                api_1.projectProductUpdate({
                    project_id: projectId,
                    product_id: row.id,
                }, params).then(response => {
                    if (response.message) {
                        this.openNotificationWithIcon('error', 'Ошибка обновления продукта', response.message);
                    }
                    response.data.result && updateSpec(specification.id);
                });
            }
            else {
                this.handleUpdateSpecProductAmount({
                    amount,
                    section_product_id: row.section_product_id,
                });
            }
        }, 600);
        this.handleUpdateSpecProductAmount = ({ amount, section_product_id }) => {
            const { specification, updateSpec } = this.props;
            const params = {
                specification_id: specification.id,
                section_product_id,
                amount,
            };
            (!!amount || amount === 0) &&
                api_1.updateSpecProductAmount(params).then(response => {
                    if (response.message) {
                        this.openNotificationWithIcon('error', 'Ошибка обновления продукта', response.message);
                    }
                    updateSpec(specification.id);
                });
        };
        //--------------------------------------------------------------------------
        this.prepareData = data => {
            const { section } = this.props;
            const tempArr = [];
            data.forEach(el => {
                tempArr.push({
                    key: el.product.id,
                    price: el.price,
                    name: el.product.name,
                    amount: el.amount,
                    id: el.product.id,
                    section: section.id,
                    section_product_id: el.id,
                    vendor_code: el.product.vendor_code,
                    total_price: el.total_price,
                    discount: el.discount,
                    in_stock: el.in_stock,
                    active: el.active,
                });
            });
            return tempArr;
        };
        this.handleDropProduct = data => {
            const { section } = this.props;
            const dataArr = data.row.split('_');
            const draggedProductId = parseInt(dataArr[0]);
            const draggedSectionId = parseInt(dataArr[1]);
            const count = parseInt(dataArr[2]);
            const sectionProductId = parseInt(dataArr[3]);
            if (section.id && section.id !== draggedSectionId) {
                this.setState({
                    moveModalIsVisible: true,
                    currentProductId: draggedSectionId ? sectionProductId : draggedProductId,
                    currentSectionId: draggedSectionId,
                    currentProductAmount: count,
                    productCount: count,
                });
            }
        };
        this.handleCloseModal = () => {
            this.setState({
                moveModalIsVisible: false,
                productCount: 0,
                currentSectionId: false,
                currentProductId: false,
                currentProductAmount: 0,
            });
        };
        this.handleMoveProduct = () => {
            const { currentProductId, productCount, currentSectionId, targetSection } = this.state;
            const { specification, setSections } = this.props;
            if (!currentSectionId) {
                if (currentProductId) {
                    this.setState({ moveProductLoading: true });
                    api_1.moveProduct({
                        specification_id: specification.id,
                        product_id: currentProductId,
                        section_id: targetSection.id,
                        amount: productCount,
                    })
                        .then(response => {
                        this.setState({ moveProductLoading: false });
                        this.handleCloseModal();
                        setSections(response.data);
                    })
                        .catch(err => {
                        this.openNotificationWithIcon('error', 'Нельзя перенести продукт', '');
                        this.handleCloseModal();
                        this.setState({ moveProductLoading: true });
                    });
                }
            }
            else {
                const params = {
                    specification_id: specification.id,
                    specification_product: currentProductId,
                    section_from: currentSectionId,
                    section_to: targetSection.id,
                    amount: productCount,
                };
                api_1.replaceProduct(params).then(response => {
                    this.handleCloseModal();
                    setSections(response.data);
                });
            }
        };
        this.handleChangeProductCount = e => {
            this.setState({ productCount: parseInt(e.target.value) });
        };
        this.changeTargetSection = value => {
            this.setState({ targetSection: value });
        };
    }
    render() {
        const { section, sections } = this.props;
        const { moveModalIsVisible, productCount, currentProductAmount, targetSection, moveProductLoading, } = this.state;
        return (React.createElement(React.Fragment, null,
            React.createElement(Modal_1.default, { isOpen: moveModalIsVisible, onClose: this.handleCloseModal, children: React.createElement("div", null,
                    React.createElement("h4", null, "\u041F\u0435\u0440\u0435\u043D\u0435\u0441\u0442\u0438 \u043F\u0440\u043E\u0434\u0443\u043A\u0442"),
                    React.createElement(Dropdown_1.default, { values: sections.filter(el => !!el.id), action: this.changeTargetSection, defaultId: targetSection.id, defaultName: targetSection.title, disableClear: true, ref: this.selectTargetRef }),
                    React.createElement("div", { className: "row" },
                        React.createElement("div", { className: "col-sm-6 mt-3" },
                            React.createElement(Input_1.default, { onChange: this.handleChangeProductCount, value: productCount, type: "number", icon: React.createElement("div", null,
                                    "/ ",
                                    currentProductAmount) })),
                        React.createElement("div", { className: "col-sm-6 mt-3" },
                            React.createElement(Button_1.default, { className: "float-sm-right", onClick: this.handleMoveProduct, value: "Переместить продукт", isLoading: moveProductLoading, disabled: productCount <= 0 || moveProductLoading })))) }),
            React.createElement(react_drag_and_drop_1.Droppable, { types: ['row'], onDrop: this.handleDropProduct },
                React.createElement(antd_1.Table, { onRow: (record, rowIndex) => {
                        return {
                            record,
                        };
                    }, dataSource: this.prepareData(section.products), columns: this.columns, key: section.id, pagination: false, components: this.components }))));
    }
}
exports.SpecTable = SpecTable;
exports.default = SpecTable;
