import * as React from 'react';
import debounce from '../../../../../../utils/debounce.js'
import { Draggable, Droppable } from 'react-drag-and-drop';
import Modal from '../../../../../../ui/Modal';
import Button from '../../../../../../ui/Button';
import Input from '../../../../../../ui/Input';
import CheckBox from '../../../../../../ui/Checkbox';
import DropdownLegrand from '../../../../../../ui/Dropdown';
import { Menu, Dropdown, Icon, Table, notification } from 'antd';
import TableInput from './TableInput';

import {
    moveProduct,
    updateSpecProductAmount,
    updateSpecProductDiscount,
    updateSpecProductActive,
    projectProductUpdate,
    deleteProductFromSection,
    deleteProductFromProject,
    replaceProduct,
} from './api';

const DraggbleRow = row => {
    return (
        <Draggable
            type="row"
            data={`${row.record.id}_${row.record.section}_${row.record.amount}_${row.record.section_product_id}`}
            key={row.record.id}
            className="draggble-table-row"
        >
            {row.children}
        </Draggable>
    );
};

const checkboxVIsibility = false;

export class SpecTable extends React.Component<any, any> {
    state = {
        moveModalIsVisible: false,
        productCount: 0,
        currentProductId: false,
        currentProductAmount: 0,
        currentSectionId: false,
        targetSection: this.props.section,
        moveProductLoading: false,
    };

    selectTargetRef = React.createRef<DropdownLegrand>();

    components = {
        body: {
            row: DraggbleRow,
        },
    };

    columns = [
        {
            title: this.props.section.title,
            dataIndex: 'name',
            key: 'name',
            width: 250,
            ellipsis: true,
            render: (text, row, index) => {
                const {
                    section: { fake_section },
                } = this.props;

                const menu = (
                    <Menu className="spec-context-menu">
                        <Menu.Item>
                            <button className="spec-context-menu-btn" onClick={() => this.handleMoveProductButton(row)}>
                                Перенести
                            </button>
                        </Menu.Item>
                        <Menu.Item>
                            {fake_section ? (
                                <button onClick={() => this.handleDeleteProjectProduct(row.id)}>Удалить</button>
                            ) : (
                                <button onClick={() => this.handleDeleteSectionProduct(row.section_product_id)}>
                                    Убрать из раздела
                                </button>
                            )}
                        </Menu.Item>
                    </Menu>
                );

                return {
                    children: (
                        <div className="spec-table-name-wrapper">
                            <Dropdown overlay={menu} className="spec-context-menu-item">
                                <Icon type="menu" />
                            </Dropdown>
                            {checkboxVIsibility && (
                                <div className="spec-table-check-wrapper">
                                    <CheckBox
                                        checked={row.active}
                                        onChange={value => {
                                            this.handleChangeActive(value, row);
                                        }}
                                    />
                                </div>
                            )}

                            <span>{text}</span>
                        </div>
                    ),
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
                    children: !this.props.isLoading && (
                        <TableInput
                            type="number"
                            value={text}
                            minMax={{ min: 0, max: 100 }}
                            onChange={value => {
                                this.handleChangeDiscountValue(value, row);
                            }}
                            disabled={this.props.isLoading}
                        />
                    ),
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
                    children: !this.props.isLoading && (
                        <TableInput
                            type="number"
                            value={text}
                            minMax={{ min: 1, max: 999 }}
                            onChange={value => {
                                this.handleChangeAmountValue(value, row);
                            }}
                            disabled={this.props.isLoading}
                        />
                    ),
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

    handleMoveProductButton = row => {
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
        } else {
            this.openNotificationWithIcon(
                'error',
                'Нельзя перенести продукт',
                'Вы еще не создали разделы спецификации',
            );
        }
    };

    openNotificationWithIcon = (type, message, description) => {
        notification[type]({
            message,
            description,
        });
    };

    handleDeleteProjectProduct = product_id => {
        const { projectId, specification, updateSpec } = this.props;

        deleteProductFromProject(projectId, product_id).then(response => {
            if (response.message) {
                this.openNotificationWithIcon('error', 'Нельзя удалить из проекта', response.message);
            }
            updateSpec(specification.id);
        });
    };

    handleDeleteSectionProduct = specification_product_id => {
        const { specification, updateSpec } = this.props;

        deleteProductFromSection(specification.id, specification_product_id).then(response => {
            if (response.message) {
                this.openNotificationWithIcon('error', 'Нельзя удалить продукт', response.message);
            }
            updateSpec(specification.id);
        });
    };
    // CHANGE ACTIVE
    //--------------------------------------------------------------------------
    handleChangeActive = (value, row) => {
        const {
            specification,
            projectId,
            updateSpec,
            section: { fake_section },
        } = this.props;

        if (fake_section) {
            const params = {
                active: !row.active,
            };

            projectProductUpdate(
                {
                    project_id: projectId,
                    product_id: row.id,
                },
                params,
            ).then(response => {
                if (response.message) {
                    this.openNotificationWithIcon('error', 'Ошибка обновления продукта', response.message);
                }
                response.data.result && updateSpec(specification.id);
            });
        } else {
            const params: any = {
                specification_id: specification.id,
                section_product_id: row.section_product_id,
                active: value ? 1 : 0,
            };
            updateSpecProductActive(params).then(response => {
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
    handleChangeDiscountValue = debounce((value = 0, row) => {
        const {
            specification,
            projectId,
            updateSpec,
            section: { fake_section },
        } = this.props;

        const intValue = parseInt(value.toString());
        const discount = intValue <= 0 ? 0 : intValue;

        if (fake_section) {
            const params = {
                discount,
            };

            projectProductUpdate(
                {
                    project_id: projectId,
                    product_id: row.id,
                },
                params,
            ).then(response => {
                if (response.message) {
                    this.openNotificationWithIcon('error', 'Ошибка обновления продукта', response.message);
                }
                response.data.result && updateSpec(specification.id);
            });
        } else {
            this.handleUpdateSpecProductDiscount({
                discount,
                section_product_id: row.section_product_id,
            });
        }
    }, 600);

    handleUpdateSpecProductDiscount = ({ discount, section_product_id }: any) => {
        const { specification, updateSpec } = this.props;
        const params: any = {
            specification_id: specification.id,
            section_product_id,
            discount,
        };

        (!!discount || discount === 0) &&
            updateSpecProductDiscount(params).then(response => {
                if (response.message) {
                    this.openNotificationWithIcon('error', 'Ошибка обновления продукта', response.message);
                }
                updateSpec(specification.id);
            });
    };
    //--------------------------------------------------------------------------

    // CHANGE AMOUNT
    //--------------------------------------------------------------------------
    handleChangeAmountValue = debounce((value, row) => {
        const {
            projectId,
            specification,
            updateSpec,
            section: { fake_section },
        } = this.props;

        const intValue = parseInt(value);
        const amount = intValue <= 0 ? 1 : intValue;

        if (fake_section) {
            const params = {
                amount,
            };

            projectProductUpdate(
                {
                    project_id: projectId,
                    product_id: row.id,
                },
                params,
            ).then(response => {
                if (response.message) {
                    this.openNotificationWithIcon('error', 'Ошибка обновления продукта', response.message);
                }
                response.data.result && updateSpec(specification.id);
            });
        } else {
            this.handleUpdateSpecProductAmount({
                amount,
                section_product_id: row.section_product_id,
            });
        }
    }, 600);

    handleUpdateSpecProductAmount = ({ amount, section_product_id }: any) => {
        const { specification, updateSpec } = this.props;
        const params: any = {
            specification_id: specification.id,
            section_product_id,
            amount,
        };

        (!!amount || amount === 0) &&
            updateSpecProductAmount(params).then(response => {
                if (response.message) {
                    this.openNotificationWithIcon('error', 'Ошибка обновления продукта', response.message);
                }
                updateSpec(specification.id);
            });
    };
    //--------------------------------------------------------------------------

    prepareData = data => {
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

    handleDropProduct = data => {
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

    handleCloseModal = () => {
        this.setState({
            moveModalIsVisible: false,
            productCount: 0,
            currentSectionId: false,
            currentProductId: false,
            currentProductAmount: 0,
        });
    };

    handleMoveProduct = () => {
        const { currentProductId, productCount, currentSectionId, targetSection } = this.state;
        const { specification, setSections } = this.props;

        if (!currentSectionId) {
            if (currentProductId) {
                this.setState({ moveProductLoading: true });
                moveProduct({
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
        } else {
            const params = {
                specification_id: specification.id,
                specification_product: currentProductId,
                section_from: currentSectionId,
                section_to: targetSection.id,
                amount: productCount,
            };
            replaceProduct(params).then(response => {
                this.handleCloseModal();
                setSections(response.data);
            });
        }
    };

    handleChangeProductCount = e => {
        this.setState({ productCount: parseInt(e.target.value) });
    };

    changeTargetSection = value => {
        this.setState({ targetSection: value });
    };

    render() {
        const { section, sections } = this.props;
        const {
            moveModalIsVisible,
            productCount,
            currentProductAmount,
            targetSection,
            moveProductLoading,
        } = this.state;

        return (
            <React.Fragment>
                <Modal
                    isOpen={moveModalIsVisible}
                    onClose={this.handleCloseModal}
                    children={
                        <div>
                            <h4>Перенести продукт</h4>
                            <DropdownLegrand
                                values={sections.filter(el => !!el.id)}
                                action={this.changeTargetSection}
                                defaultId={targetSection.id}
                                defaultName={targetSection.title}
                                disableClear
                                ref={this.selectTargetRef}
                            />
                            <div className="row">
                                <div className="col-sm-6 mt-3">
                                    <Input
                                        onChange={this.handleChangeProductCount}
                                        value={productCount}
                                        type="number"
                                        icon={<div>/ {currentProductAmount}</div>}
                                    />
                                </div>
                                <div className="col-sm-6 mt-3">
                                    <Button
                                        className="float-sm-right"
                                        onClick={this.handleMoveProduct}
                                        value="Переместить продукт"
                                        isLoading={moveProductLoading}
                                        disabled={productCount <= 0 || moveProductLoading}
                                    />
                                </div>
                            </div>
                        </div>
                    }
                />

                <Droppable types={['row']} onDrop={this.handleDropProduct}>
                    <Table
                        onRow={(record, rowIndex) => {
                            return {
                                record,
                            };
                        }}
                        dataSource={this.prepareData(section.products)}
                        columns={this.columns}
                        key={section.id}
                        pagination={false}
                        components={this.components}
                    />
                </Droppable>
            </React.Fragment>
        );
    }
}

export default SpecTable;
