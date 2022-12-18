import * as React from 'react';
import AddItem from '../../../../../../ui/AddItem';
import Input from '../../../../../../ui/Input';
import debounce from '../../../../../../utils/debounce.js'
import { reducer } from './reducer';
import { Icon, AutoComplete } from 'antd';
const { Option } = AutoComplete;
import { searchProducts, addProduct, addProductToSection } from './api';

interface IAddProduct {
    projectId: number;
    section: any;
    specificationId: number;
    updateSpec: (id: number) => void;
}

const searchRowStyle = { width: 300 };

const AddProduct = ({ projectId, section, updateSpec, specificationId }: IAddProduct) => {
    const [{ isLoading, dropdownIsVisible, values }, dispatch] = React.useReducer(reducer, {
        isLoading: false,
        dropdownIsVisible: false,
        values: [],
    });

    const onSelect = product_id => {
        if (section.fake_section) {
            addProduct({
                product: parseInt(product_id),
                projects: [
                    {
                        amount: 1,
                        project: projectId,
                    },
                ],
            }).then(result => {
                dispatch({ type: 'hide-search' });
                updateSpec(projectId);
            });
        } else {
            addProductToSection({
                specification_id: specificationId,
                specification_section_id: section.id,
                product: product_id,
            }).then(result => {
                dispatch({ type: 'hide-search' });
                updateSpec(projectId);
            });
        }
    };

    const searchResult = async query => {
        const response = await searchProducts({ search: query, limit: 10 });
        return response.data.products;
    };

    const handleSearch = debounce(async value => {
        const result = await searchResult(value);
        dispatch({ type: 'set-values', payload: result });
    }, 1000);

    const handleShowSerachRow = () => {
        dispatch({ type: 'open-search' });
    };

    return (
        <div className="add-product-to-spec-row">
            {isLoading}
            {dropdownIsVisible ? (
                <div className="global-search-wrapper" style={searchRowStyle}>
                    <AutoComplete
                        className="global-search"
                        size="large"
                        style={{ width: '100%' }}
                        dataSource={values.map(renderOption)}
                        onSelect={onSelect}
                        onSearch={handleSearch}
                        optionLabelProp="text"
                    >
                        <Input icon={<Icon type="search" />} placeholder="Поиск продукта" />
                    </AutoComplete>
                </div>
            ) : (
                <AddItem icon={<Icon type="plus-square" />} text="Добавить продукт" action={handleShowSerachRow} />
            )}
        </div>
    );
};

function renderOption(item: any) {
    return (
        <Option key={item.id}>
            <span className="add-product-to-spec-vendor-code">{item.vendor_code}</span>
            <span className="add-product-to-spec-name">{item.name}</span>
        </Option>
    );
}

export default AddProduct;
